<?php

namespace App\Controllers;

use App\Helpers\Sql;
use App\Services\Db;
use DiDom\Element;
use App\Exceptions\ErrorException;
use App\Libraries\Screens;
use App\Mappers\FacebookMapper;
use App\Mappers\VKMapper;
use App\Models\Collection\ProjectLangs;
use App\Models\Constant\Language;
use App\Models\Constant\ProjectStatus;
use App\Models\Table\Hyiplog;
use App\Models\Table\Project;
use App\Models\Table\ProjectLang;
use App\Models\Table\Queue as QueueModel;
use App\Models\Table\User;
use App\Requests\Investment\ReloadScreenshotRequest;
use App\Requests\Telegram\SendPhotoRequest;
use App\Services\HyipboxService;
use App\Services\HyiplogsService;
use App\Services\InvestmentService;
use App\Services\VKService;

class Queue
{
    private int $fileTime;

    public function __construct()
    {
        if (!CLI) {
            throw new \RuntimeException('Only cli available');
        }
        $this->fileTime = filemtime(__FILE__);
        Output()->disableLayout();
    }

    private function getPids(string $func): array
    {
        $cmd = 'ps -aux | grep "php.*/queue/'.$func.'" | grep -v grep | grep -v "/bin/sh" | awk \'{ print $2 }\'';
        $output = [];
        exec($cmd, $output);
        return $output;
    }

    private function killZombies(): void
    {
        exec('ps -ef | grep defunct | grep -v grep | cut -b8-20 | xargs kill -9');
    }

    private function queue(int $actionID, callable $functionForCall, string $funcName): void
    {
        $queueOriginal = (new QueueModel());
        while (true) {
            clearstatcache(true, __FILE__);
            if ($this->fileTime !== filemtime(__FILE__)) {
                exit();
            }

            $queue = clone $queueOriginal;
            $queue->getRowFromDbAndFill([
                'action_id' => $actionID,
                'status_id' => QueueModel::STATUS_CREATED,
            ], '*', 'id desc');

            if (!$queue->id) {
                unset($queue);
                gc_collect_cycles();
                sleep(3);
                continue;
            }

            $queue->status_id = QueueModel::STATUS_STARTED;
            $queue->start_time = date('Y-m-d H:i:s');
            $queue->save();

            try {
                $functionForCall($queue);

                $queue->end_time = date('Y-m-d H:i:s');
                $queue->status_id = QueueModel::STATUS_FINISHED;
                $queue->save();

                unset($queue);
            } catch (\Throwable $e) {
                sendToTelegram([
                    'method'        => __METHOD__ .'->' . $funcName,
                    'line'          => __LINE__,
                    '$queue'        => $queue->toArray(),
                    'exception'     => [
                        'line'      => $e->getLine(),
                        'message'   => $e->getMessage(),
                        'file'      => $e->getFile(),
                    ],
                ]);
            }
        }
    }

    public function screenshot(): void
    {
        if (count($this->getPids(__FUNCTION__)) > 1) {
            exit(1);
        }

        $this->queue(QueueModel::ACTION_ID_SCREENSHOT, function (QueueModel $queue) {
            /** @var Project $project */
            $project = (new Project())->getById($queue->payload['project_id']);

            Screens::createFolder($project->id);

            $this->reTry(function () use ($project) {
                (new InvestmentService())->reloadScreen(new ReloadScreenshotRequest(['project' => $project->id]));
            });

            $user = (new User())->getById($project->admin);
            $message = new SendPhotoRequest([
                'chat_id' => \Config::TELEGRAM_ADD_GROUP_PROJECT_ID,
                'caption' => sprintf('New project %s is added by %s', $project->url, $user->login),
                'photo'   => Screens::getOriginalJpgScreen($project->id),
                'reply_markup' => [
                    'inline_keyboard' => [
                        [
                            ['text' => '👍 public', 'callback_data' => json_encode([
                                'action' => Telegram::ACTIVATE,
                                'project_id' => $project->id
                            ], JSON_THROW_ON_ERROR)],
//                            ['text' => '⚒ reload screen', 'callback_data' => json_encode([
//                                'action' => Telegram::RELOAD_SCREEN,
//                                'project_id' => $project->id
//                            ], JSON_THROW_ON_ERROR)],
                        ]
                    ]
                ],
            ]);
            App()->telegram()->sendPhoto($message);

            unset($message, $project, $browser, $page, $factory);
        }, __FUNCTION__);
    }

    private function reTry(callable $functionForCall, int $try = 1)
    {
        try {
            return $functionForCall();
        } catch (\Throwable $e) {
            if ($try === 3) {
                throw $e;
            }
            sleep($try * 4);
            return $this->reTry($functionForCall, ++$try);
        }
    }

    // Post to social nets
    public function post(): void
    {
        if (count($this->getPids(__FUNCTION__)) > 1) {
            exit(1);
        }

        $vkService = new VKService();
        $this->queue(QueueModel::ACTION_ID_POST_TO_SOCIAL, static function (QueueModel $queue) use ($vkService) {
            $project = (new Project())->getById($queue->payload['project_id']);

            $projectLangs = new ProjectLangs(['project_id' => $project->id]);

            $facebookPageLanguages = array_keys(FacebookMapper::getCollection());
            $vkPageLanguages = array_keys(VKMapper::getCollection());
            /** @var ProjectLang $projectLang */
            foreach ($projectLangs as $projectLang) {
                if (in_array($projectLang->lang_id, $facebookPageLanguages, true)) {
                    $url = sprintf('%s/Investment/details/site/%s/lang/%s/', SITE, $project->url, Language::getConstNameLower($projectLang->lang_id));
                    $description = str_replace(['</br>', $project->url], ['', $project->name], $projectLang->description);

                    App()->facebook()->sendPhoto(
                        $projectLang->lang_id,
                        Screens::getOriginalJpgScreen($project->id),
                        sprintf("%s\n\n%s\n\n%s %s", $url, $description, '#invest', '#money'),
                    );
                }
                if (in_array($projectLang->lang_id, $vkPageLanguages, true)) {
                    $url = sprintf('%s/Investment/details/site/%s/lang/%s', SITE, $project->url, Language::getConstNameLower($projectLang->lang_id));
                    $description = str_replace('</br>', '', $projectLang->description);
                    $vkService->sendToWall(
                        $projectLang->lang_id,
                        Screens::getOriginalJpgScreen($project->id),
                        $url,
                        sprintf("%s\n\n%s\n\n%s %s", $url, $description, '#invest', '#money'),
                        $project->name,
                    );
                    sleep(2);
                    $vkService->sendToMarket(
                        $projectLang->lang_id,
                        Screens::getOriginalJpgScreen($project->id),
                        $url,
                        sprintf("%s\n\n%s\n\n%s %s", $url, $description, '#invest', '#money'),
                        $project->name,
                    );
                }
                sleep(3);
            }

            unset($projectLangs, $project);
        }, __FUNCTION__);
    }

    public function checkScam(int $projectId = 0): void
    {
        if (count($this->getPids(__FUNCTION__)) > 1) {
            exit(1);
        }

        $investmentService = new InvestmentService();
        while (($project = $investmentService->getNextProject($projectId, ProjectStatus::ACTIVE))->id) {
            $projectId = $project->id;
            try {
                if (
                    HyipboxService::inst()->setUrl($project->url)->isScam()
                    || HyiplogsService::inst()->setUrl($project->url)->isScam()
                ) {
                    $project->status_id = ProjectStatus::SCAM;
                    $project->scam_date = date(\DATE_ATOM);
                    $project->save();

                    App()->telegram()->sendPhoto(new SendPhotoRequest([
                        'chat_id' => \Config::TELEGRAM_ADD_GROUP_PROJECT_ID,
                        'caption' => sprintf('☠️ %s is scam', $project->url),
                        'photo'   => Screens::getWebpThumb($project->id),
                    ]));
                }

                unset($project);
                sleep(3);
            } catch (ErrorException $e) {
                //
            }
        }
    }

    public function parseNewProjects(): void
    {
        if (count($this->getPids(__FUNCTION__)) > 1) {
            exit(1);
        }

        $query = http_build_query([
            'hlindex[from]' => 1,
            'hlindex[to]'   => 10,
            'status[1]'     => 1,
            'design'        => 1,
            'license'       => 1,
            'monitors'      => 1,
            'deposits'      => 1,
        ]);

        try {
            $document = HyiplogsService::inst()->setUrl("hyips/?$query")->getDocument();

            /** @var Element $row */
            foreach ($document->find('div.all-hyips-list div.item.ovh') as $row) {
                $rating = $row->first('div.hl-index-box span')->text();
                $projectUrl = $row->first('div.info-content div.name-box a.grey-link')->text();
                (new Hyiplog())->getRowFromDbAndFill(['url' => $projectUrl])->fromArray([
                    'rating' => $rating,
                ])->save();
            }
        } catch (\Throwable $e) {
            sendToTelegram([
                'f'             => __METHOD__,
                'line'          => __LINE__,
                'exception'     => [
                    'line'      => $e->getLine(),
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile(),
                ],
            ]);
        }
    }

    public function fillProject(): void {
        if (count($this->getPids(__FUNCTION__)) > 1) {
            exit(1);
        }

        $errors = [];
        $list = Db::inst()->exec(new Sql('SELECT * FROM hyiplogs ORDER by id desc LIMIT 1 '));
        foreach ($list as $item) {
            if (($project = (new Project())->getRowFromDbAndFill(['url' => $item['url']]))->id) {
                continue;
            }
            try {
                (new InvestmentService())->parseProject($project);
            } catch (ErrorException $e) {
                $errors[$item['url']] = [$e->getKey(), $e->getLine(), $e->getMessage(), $e->getFile()];
            } catch (\Throwable $e) {
                $errors[$item['url']] = [$e->getLine(), $e->getMessage(), $e->getFile()];
            }
            gc_collect_cycles();
        }
        if (!empty($errors)) {
            sendToTelegram([
                'f' => __METHOD__,
                'line' => __LINE__,
                '$errors' => $errors,
            ]);
        }
    }
}
