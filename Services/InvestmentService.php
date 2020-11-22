<?php

namespace Services;

use Core\Database;
use Dejurin\GoogleTranslateForFree;
use DiDom\Document;
use Exceptions\ErrorException;
use Helpers\HttpClient\CurlHttpClient;
use Helpers\HttpClient\CurlRequestDto;
use Helpers\Output;
use Helpers\Validator;
use Libraries\Screens;
use Models\Collection\Languages;
use Models\Collection\MVProjectCounts;
use Models\Collection\MVProjectFilterAvailableLangs;
use Models\Collection\MVProjectLangs;
use Models\Collection\MVProjectSearchs;
use Models\Constant\ProjectStatus;
use Models\Constant\User as UserConstant;
use Models\Constant\UserStatus;
use Models\Table\Language;
use Models\Table\Project;
use Models\Table\Queue;
use Models\Table\User;
use Requests\Investment\ChangeStatusRequest;
use Requests\Investment\ReloadScreenshotRequest;
use Traits\DecodeErrorException;

class InvestmentService
{
    use DecodeErrorException;

    public function changeStatus(ChangeStatusRequest $request): Project {
        $project = (new Project())->getById($request->project);
        $project->status_id = $request->status;
        if ($request->status === ProjectStatus::SCAM) {
            $project->scam_date = date(\DATE_ATOM);
        }
        $project->save();

        self::refreshMViews();
        Db()->setTable('mv_sitemapxml')->refresh(false);

        if ($request->status === ProjectStatus::ACTIVE) {
            (new Queue([
                'action_id'  => Queue::ACTION_ID_POST_TO_SOCIAL,
                'status_id'  => Queue::STATUS_CREATED,
                'payload'    => [
                    'project_id' => $project->id,
                ],
            ]))->save();
        }

        return $project;
    }

    public function reloadScreen(ReloadScreenshotRequest $request): Project {
        /** @var Project $project */
        $project = (new Project())->getById($request->project);

        $url = sprintf('https://hyipbox.org/details/%s', $project->url);

        try {
            $document = new Document($url, true);
            $url = $document->first('a.zoom')->attr('href');
        } catch (\Exception $exception) {
            throw new ErrorException('Parse error', 'project was n\'t found');
        }

        $temp = ROOT . '/screens/temp/' . $project->id;
        file_put_contents($temp . '.xxx', file_get_contents('https://hyipbox.org' . $url));
        Screens::toJpg($temp . '.xxx', $temp . '.jpg');
        Screens::crop($temp . '.jpg', Screens::getOriginalJpgScreen($project->id));
        Screens::makeThumbs($project->url, $project->id);
        unlink($temp . '.xxx');
        unlink($temp . '.jpg');

        return $project;
    }

    public function parseInfo(string $url) {
        $hyiplogsService = $this->try(function () use ($url) {
            return HyiplogsService::getInstance()->setUrl($url);
        });
        $hyipboxService = $this->try(function () use ($url) {
            return HyipboxService::getInstance()->setUrl($url);
        });
        if (Error()->hasError()) {
            return;
        }

        try {
            if ($hyipboxService->isScam()) {
                Output()->addAlertDanger(Translate()->scam, Translate()->scam);
                return;
            }

            if ($title = $hyipboxService->getTitle()) {
                Output()->addFunction('setProjectTitle', ['title' => $title]);
            }

            if (($timestamp = $hyipboxService->getStartDate()) > 0) {
                Output()->addFunction('setDatepicker', ['date' => $timestamp]);
            }

            if (($paymentTypeId = $hyipboxService->getPaymentTypeId()) > 0) {
                Output()->addFunction('setPaymentType', ['paymentType' => $paymentTypeId]);
            }

            if ($minDeposit = $hyipboxService->getMinDeposit()) {
                Output()->addFunction('setMinDeposit', $minDeposit);
            }

            if ($plans = $hyiplogsService->getPlans()) {
                Output()->addFunction('setPlans', ['plans' => $plans]);
            }

            if ($referralPlans = $hyipboxService->getReferralPlans()) {
                Output()->addFunction('setReferralPlans', ['plans' => $referralPlans]);
            }

            if ($payments = $hyipboxService->getPayments()) {
                Output()->addFunction('setPayments', ['payments' => $payments]);
            }

            if (($description = $hyipboxService->getDescription()) && $description) {
                Output()->addFunction('setDescriptions', [
                    'descriptions' => $this->multiTranslate($this->detectLanguage($description), $description)
                ]);
            }
        } catch (\Exception $exception) {
            throw new ErrorException('Parse error', 'project was n\'t found');
        }
    }

    public function detectLanguage(string $text): string {
        $ld = new \LanguageDetection\Language(['en', 'zh', 'ru']);
        return array_keys($ld->detect($text)->bestResults()->close())[0] ?? '';
    }

    public function multiTranslate(string $fromLang, string $description): array {
        $languages = new Languages(['pos' => range(1, 19)], 'pos');
        /** @var Language $lang */
        $result = [];
        foreach ($languages as $lang) {
            try {
                $result[$lang->id] =
                    $fromLang === $lang->shortname
                        ? $description
                        : GoogleTranslateForFree::translate($fromLang, $lang->shortname, $description);
            } catch (\Exception $e) {
                continue;
            }
            usleep(0_050000); // 0.05 sec
        }

        return $result;
    }

    public function getNextProject(int $projectId, int $projectStatus): Project {
        return (new Project())->fromArray(Db()->rawSelect(sprintf(
                'select id, url from project where id > %d and status_id = %d order by id asc limit 1',
                $projectId,
                $projectStatus
            ))[0] ?? []);
    }

    public function parseProject(Project $project): void {
        Output::getInstance()->disableLayout();

        $hyiplogsService = HyiplogsService::getInstance()->setUrl($project->url);
        $hyipboxService = HyipboxService::getInstance()->setUrl($project->url);

        try {
            if ($hyipboxService->isScam()) {
                return;
            }

            $plans = $hyiplogsService->getPlans();
            if (!$minDeposit = $hyipboxService->getMinDeposit()) {
                return;
            }

            $project->fromArray([
                'name'             => $hyipboxService->getTitle(),
                'admin'            => UserConstant::SYSTEM,
                'start_date'       => date(\DATE_ATOM, $hyipboxService->getStartDate()),
                'paymenttype'      => $hyipboxService->getPaymentTypeId(),
                'ref_percent'      => $hyipboxService->getReferralPlans(),
                'plan_percents'    => array_column($plans, 0),
                'plan_period'      => array_column($plans, 1),
                'plan_period_type' => array_column($plans, 2),
                'currency'         => $minDeposit['currency'],
                'min_deposit'      => $minDeposit['deposit'],
                'id_payments'      => array_values(array_unique(array_merge(
                    $hyipboxService->getPayments(),
                    $hyiplogsService->getPayments()
                ))),
                'ref_url'          => 'https://' . $project->url,
                'status_id'        => ProjectStatus::NOT_PUBLISHED,
                'rating'           => $hyiplogsService->getRating(),
            ]);

            if (count(array_filter($project->toArray())) !== 15) {
                return;
            }

            $description = $hyipboxService->getDescription();
            if (mb_strlen($description) < 50) {
                return;
            }

            $lang = $this->detectLanguage($description);
            if ($lang === '') {
                return;
            }

            $project->save();

            $descriptions = $this->multiTranslate($lang, $description);
            // Сохраняем описания
            $sql = "INSERT INTO project_lang(project_id, lang_id, description) VALUES ";
            $values = [];
            foreach ($descriptions as $langId => $description) {
                $desctiption = \str_replace(["\n", "'"], ['</br>', "''"], $description);
                $values[] = "({$project->id}, {$langId}, '$desctiption')";
            }
            Database::getInstance()->rawExecute($sql . implode(',', $values));

            (new Queue([
                'action_id'  => Queue::ACTION_ID_SCREENSHOT,
                'status_id'  => Queue::STATUS_CREATED,
                'payload'    => [
                    'project_id' => $project->id,
                ],
            ]))->save();

            self::refreshMViews();

            if ($hid = $hyiplogsService->getProjectId()) {
                $this->parseVotes($project->id, (int)$hid);
            }
        } catch (\Exception $e) {
            throw new ErrorException('Parse error: ' . $project->url, $e->getMessage());
        }

    }

    public static function refreshMViews(): void {
        MVProjectFilterAvailableLangs::refresh();
        MVProjectLangs::refresh();
        MVProjectSearchs::refresh();
        MVProjectCounts::refresh();
    }

    private function parseVotes(int $projectId, int $hid) {
        $base = 'https://hyiplogs.com/';

        $result = (new CurlHttpClient())->post(new CurlRequestDto($base . 'votes/', [], [], [
            'hid' => $hid,
        ]));
        $doc = new Document($result->getRawBody());

        $items = $doc->xpath('//div[@class="main-vote-box"]/div[@class="vote-el"]/div') ?? [];

        foreach ($items as $index => $item) {
            $name = $item->first('.vote-body .top-line .fl .fs15')->text();
            $login = '_' . strtolower(preg_replace('/[^' . Validator::LOGIN . ']/i', '', $name));

            User::validationOff('login');
            $user = (new User())->getRowFromDbAndFill([
                'login' => $login
            ]);
            if ($user->id === null) {
                $user->name = $name;
                $user->password = str_repeat('x', 53);
                $user->status_id = UserStatus::FAKE;
                $user->lang_id = \Models\Constant\Language::EN;

                $avatar = ($img = $item->first('.ava .img img')) === null ? '' : $img->attr('src');
                $user->has_photo = $avatar !== '';
                $user->save();
                if ($avatar !== '') {
                    $path = ROOT . '/assets/img/user/';
                    $temp = $path . 'temp_' . $user->id;
                    file_put_contents($temp, file_get_contents($avatar));
                    Screens::toJpg($temp, $temp . '.jpg');
                    Screens::makeThumb($temp . '.jpg', $path . $user->id . '.jpg', 64, 64, 95);
                    Screens::makeWebp($path . $user->id . '.jpg', $path . $user->id . '.webp', 95);
                    unlink($temp);
                    unlink($temp . '.jpg');
                }
            }

            $message = \trim($item->first('.vote-body .txt')->text());
            $message = '<p>' . \str_replace(["\n", "'", '\\'], ['</p><p>', '', ''], $message) . '</p>';
            $message = \preg_replace('/\s+/', ' ', $message);

            $dt = $item->first('.vote-body .top-line .vote-date')->text();
            preg_match_all('/(\d*[dhm])/', $dt, $matches);
            $date = implode(' ', $matches[1]);

            $sql = "
                INSERT INTO message(date_create, user_id, project_id, lang_id, message, session_id)
                VALUES (NOW() - INTERVAL '$date', {$user->id}, $projectId, -1, '$message', 1);
            ";
            Database::getInstance()->rawExecute($sql);
        }
    }
}