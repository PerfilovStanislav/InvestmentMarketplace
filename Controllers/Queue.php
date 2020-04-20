<?php

namespace Controllers;

use Helpers\Locales\En;
use Helpers\Locales\Ru;
use Libraries\Screens;
use Models\Collection\ProjectLangs;
use Models\Table\Project;
use Models\Table\ProjectLang;
use Models\Table\Queue as QueueModel;
use Requests\Telegram\SendPhotoRequest;
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

    public function screenshot()
    {
        $this->killZombies();

        if (count($this->getPids('screenshot')) > 1) {
            exit(1);
        }

        $this->killChrome();
        sleep(3);

        $queueOriginal = (new QueueModel());

        require(ROOT . '/composer/vendor/autoload.php');

        $factory = new \HeadlessChromium\BrowserFactory('google-chrome');
        $browser = $factory->createBrowser([
            'headless' => true,
            'noSandbox' => true,
            'keepAlive' => false,
            'windowSize' => [1280, 960],
            'sendSyncDefaultTimeout' => 45000
        ]);

        while (1) {
            $queue = clone $queueOriginal;
            $queue->getRowFromDbAndFill([
                'action_id' => QueueModel::ACTION_ID_SCREENSHOT,
                'status_id' => QueueModel::STATUS_CREATED,
            ]);

            if (!$queue->id) {
                sleep(3);
                continue;
            }

            exec('pgrep chrome', $chromePids);
            if (!count($chromePids)) {
                exit(1);
            }

            $queue->status_id = QueueModel::STATUS_STARTED;
            $queue->start_time = date('Y-m-d H:i:s');
            $queue->save();


            $project = (new Project())->getById($queue->payload['project_id']);

            Screens::createFolder($project->id);

            $page = $browser->createPage();
            $page->navigate('https://' . $project->url)->waitForNavigation();
            sleep(7);
            $page->screenshot([
                'format'  => 'jpeg',
                'quality' => 95,
            ])->saveToFile(Screens::getOriginalJpgScreen($project->id));
            $page->close();

            Screens::makeThumbs($project->url, $project->id);

            Investment::refreshMViews();

            $message = new SendPhotoRequest([
                'chat_id' => \Config::TELEGRAM_ADD_GROUP_PROJECT_ID,
                'caption' => sprintf('New project is added *%s* (%s)', $project->name, $project->url),
                'photo'   => Screens::getOriginalJpgScreen($project->id),
            ]);
            App()->telegram()->sendPhoto($message);

            $queue->end_time = date('Y-m-d H:i:s');
            $queue->status_id = QueueModel::STATUS_FINISHED;
            $queue->save();

            unset($message, $queue, $project);
        }
    }

    public function post()
    {
        if (count($this->getPids('post')) > 1) {
            exit(1);
        }

        $vkService = new Vk();
        $queueOriginal = (new QueueModel());

        while (1) {
            $queue = clone $queueOriginal;
            $queue->getRowFromDbAndFill([
                'action_id' => QueueModel::ACTION_ID_POST_TO_SOCIAL,
                'status_id' => QueueModel::STATUS_CREATED,
            ]);

            if (!$queue->id) {
                sleep(3);
                continue;
            }

            $queue->status_id = QueueModel::STATUS_STARTED;
            $queue->start_time = date('Y-m-d H:i:s');
            $queue->save();

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

            $queue->end_time = date('Y-m-d H:i:s');
            $queue->status_id = QueueModel::STATUS_FINISHED;
            $queue->save();

            unset($message, $queue, $project);
        }
    }
}
