<?php

namespace Services;

use Controllers\Investment;
use Dejurin\GoogleTranslateForFree;
use DiDom\Document;
use Exceptions\ErrorException;
use Helpers\Output;
use Libraries\Screens;
use Models\Collection\Languages;
use Models\Collection\MVProjectCounts;
use Models\Collection\MVProjectFilterAvailableLangs;
use Models\Collection\MVProjectLangs;
use Models\Collection\MVProjectSearchs;
use Models\Constant\ProjectStatus;
use Models\Constant\User;
use Models\Table\Language;
use Models\Table\Project;
use Models\Table\ProjectLang;
use Models\Table\Queue;
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

        $url = sprintf('https://hyiplogs.com/project/%s/', $project->url);

        try {
            $document = new Document($url, true);
            $url = $document->first('.content div.hyip-img ')->attr('data-src');
        } catch (\Exception $exception) {
            throw new ErrorException('Parse error', 'project was n\'t found');
        }

        $temp = ROOT . '/screens/temp/' . $project->id . '.jpg';
        file_put_contents($temp, file_get_contents($url));
        Screens::crop($temp, Screens::getOriginalJpgScreen($project->id));
        Screens::makeThumbs($project->url, $project->id);
        unlink($temp);

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
                'admin'            => User::SYSTEM,
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
            foreach ($descriptions as $langId => $description) {
                $projectLang              = new ProjectLang();
                $projectLang->project_id  = $project->id;
                $projectLang->lang_id     = $langId;
                $projectLang->description = str_replace("\n", '</br>', $description);
                $projectLang->save();
                unset($projectLang);
            }

            (new Queue([
                'action_id'  => Queue::ACTION_ID_SCREENSHOT,
                'status_id'  => Queue::STATUS_CREATED,
                'payload'    => [
                    'project_id' => $project->id,
                ],
            ]))->save();

            self::refreshMViews();
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
}