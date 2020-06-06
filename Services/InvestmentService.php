<?php

namespace Services;

use Controllers\Investment;
use Dejurin\GoogleTranslateForFree;
use DiDom\Document;
use Exceptions\ErrorException;
use Libraries\Screens;
use Models\Collection\Languages;
use Models\Constant\ProjectStatus;
use Models\Table\Language;
use Models\Table\Project;
use Models\Table\Queue;
use Requests\Investment\ChangeStatusRequest;
use Requests\Investment\ReloadScreenshotRequest;
use Mappers\HyiplogsMapper;

class InvestmentService
{
    public function changeStatus(ChangeStatusRequest $request): Project {
        $project = (new Project())->getById($request->project);
        $project->status_id = $request->status;
        $project->save();

        Investment::refreshMViews();
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

    /**
     * @deprecated
     */
    public function parseInfo2(string $url) {
        $url = sprintf('https://hyiplogs.com/project/%s/', $url);

        try {
            $document = new Document($url, true);
            $mapper = (new HyiplogsMapper());

            $title = trim($document->first('.content div.name-box div')->text());
            Output()->addFunction('setProjectTitle', ['title' => $title]);

            $paymentTypeId = $mapper->getPaymentTypeId(
                $document->first('.content div.info-box div.item:nth-child(4) div.txt')->text()
            );
            Output()->addFunction('setPaymentType', ['paymentType' => $paymentTypeId]);

            $paymentsText = $document->first('.content div.info-box div.item:nth-child(6) div.txt')->text();
            $payments = $mapper->payments(
                array_map(fn(string $str):string => str_replace(' ', '', trim($str)), explode(',', $paymentsText))
            );
            Output()->addFunction('selectPayments', ['payments' => array_values($payments)]);
        } catch (\Exception $exception) {
            throw new ErrorException('Parse error', 'project was n\'t found');
        }
    }

    public function parseInfo(string $url) {
        $hyipboxService = new HyipboxService($url);

        try {
            if ($hyipboxService->isScam()) {
                Output()->addAlertDanger(Translate()->scam, Translate()->scam);
                return;
            }

            if ($title = $hyipboxService->getTitle()) {
                Output()->addFunction('setProjectTitle', ['title' => ucfirst($title)]);
            }

            if (($timestamp = $hyipboxService->getStartDate()) > 0) {
                Output()->addFunction('setDatepicker', ['date' => $timestamp]);
            }

            if (($paymentTypeId = $hyipboxService->getPaymentTypeId()) > 0) {
                Output()->addFunction('setPaymentType', ['paymentType' => $paymentTypeId]);
            }

            if ($plans = $hyipboxService->getPlans($hyipboxService->getMinDeposit())) {
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
        return array_keys($ld->detect($text)->bestResults()->close())[0];
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
            usleep(0_100000); // 0.10 sec
        }

        return $result;
    }
}