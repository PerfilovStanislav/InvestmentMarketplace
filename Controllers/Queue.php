<?php

namespace Controllers;

use HeadlessChromium\BrowserFactory;
use Helpers\Locales\En;
use Helpers\Locales\Ru;
use Libraries\Screens;
use Models\Collection\ProjectLangs;
use Models\Constant\ProjectStatus;
use Models\Table\Project;
use Models\Table\ProjectLang;
use Models\Table\Queue as QueueModel;
use Models\Table\User;
use Requests\Telegram\SendPhotoRequest;
use Services\HyipboxService;
use Services\InvestmentService;
use Services\Vk;

class Queue
{
    public function __construct()
    {
        if (!CLI) {
            throw new \Exception('Only cli available');
        }
    }

    private function getPids(string $func): array
    {
        $cmd = 'ps -aux | grep "php.*/queue/'.$func.'" | grep -v grep | grep -v "/bin/sh" | awk \'{ print $2 }\'';
        $output = [];
        exec($cmd, $output);
        return $output;
    }

    private function killChrome()
    {
        exec('kill $(pgrep chrome)');
    }

    private function killZombies()
    {
        exec('ps -ef | grep defunct | grep -v grep | cut -b8-20 | xargs kill -9');
    }

    private function queue(int $actionID, callable $functionForCall)
    {
        $queueOriginal = (new QueueModel());
        while (true) {
            $queue = clone $queueOriginal;
            $queue->getRowFromDbAndFill([
                'action_id' => $actionID,
                'status_id' => QueueModel::STATUS_CREATED,
            ]);

            if (!$queue->id) {
                unset($queue);
                sleep(3);
                continue;
            }

            $queue->status_id = QueueModel::STATUS_STARTED;
            $queue->start_time = date('Y-m-d H:i:s');
            $queue->save();

            $functionForCall($queue);

            $queue->end_time = date('Y-m-d H:i:s');
            $queue->status_id = QueueModel::STATUS_FINISHED;
            $queue->save();

            unset($queue);
        }
    }

    public function screenshot()
    {
        $this->killZombies();

        if (count($this->getPids('screenshot')) > 1) {
            exit(1);
        }

        $this->killChrome();
        sleep(3);

        $this->queue(QueueModel::ACTION_ID_SCREENSHOT, static function (QueueModel $queue) {
            $project = (new Project())->getById($queue->payload['project_id']);

            Screens::createFolder($project->id);

            $factory = new BrowserFactory('google-chrome');
            $browser = $factory->createBrowser([
                'headless' => true,
                'noSandbox' => true,
                'keepAlive' => false,
                'windowSize' => [1280, 960],
                'sendSyncDefaultTimeout' => 45000
            ]);
            $page = $browser->createPage();
            $page->navigate('https://' . $project->url)->waitForNavigation();
            sleep(7);
            $page->screenshot([
                'format'  => 'jpeg',
                'quality' => 95,
            ])->saveToFile(Screens::getOriginalJpgScreen($project->id));
            $page->close();
            $browser->close();

            Screens::makeThumbs($project->url, $project->id);

            Investment::refreshMViews();

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
                            ['text' => '⚒ reload screen', 'callback_data' => json_encode([
                                'action' => Telegram::RELOAD_SCREEN,
                                'project_id' => $project->id
                            ], JSON_THROW_ON_ERROR)],
                        ]
                    ]
                ],
            ]);
            App()->telegram()->sendPhoto($message);

            unset($message, $project, $browser, $page, $factory);
        });
    }

    public function post()
    {
        if (count($this->getPids('post')) > 1) {
            exit(1);
        }

        $vkService = new Vk();
        $this->queue(QueueModel::ACTION_ID_POST_TO_SOCIAL, static function (QueueModel $queue) use ($vkService) {
            $project = (new Project())->getById($queue->payload['project_id']);

            $projectLangs = new ProjectLangs(['project_id' => $project->id]);
            /** @var ProjectLang $projectLang */
            foreach ($projectLangs as $projectLang) {
                if ($projectLang->lang_id === Ru::$id) {
                    $vkService->sendToMarket($project, $projectLang, \Config::VK_GROUP_RU);
                } elseif ($projectLang->lang_id === En::$id) {
                    $vkService->sendToMarket($project, $projectLang, \Config::VK_GROUP_EN);
                }
            }

            unset($projectLangs, $project);
        });
    }

    public function checkScam(int $projectId = 0): void
    {
        if (count($this->getPids('checkScam')) > 1) {
            exit(1);
        }

        $investmentService = new InvestmentService();
        while (($project = $investmentService->getNextProject($projectId, ProjectStatus::ACTIVE))->id) {
            if ((new HyipboxService($project->url))->isScam()) {
                $project->status_id = ProjectStatus::SCAM;
                $project->save();

                App()->telegram()->sendPhoto(new SendPhotoRequest([
                    'chat_id' => \Config::TELEGRAM_ADD_GROUP_PROJECT_ID,
                    'caption' => sprintf('☠️ %s is scam', $project->url),
                    'photo'   => Screens::getJpgThumb($project->id),
                ]));
            }

            $projectId = $project->id;
            unset($project);
            sleep(5);
        }

        Investment::refreshMViews();
    }
}
