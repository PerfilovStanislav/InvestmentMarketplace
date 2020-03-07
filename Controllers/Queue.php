<?php

namespace Controllers;

use Libraries\Screens;
use Models\Table\Project;
use Models\Table\Queue as QueueModel;
use Requests\Telegram\SendPhotoRequest;

class Queue
{
    public function __construct()
    {
        if (!CLI) {
            throw new \Exception('Only cli available');
        }
    }

    public function screenshot()
    {
        $queueOriginal = (new QueueModel());

        require(ROOT . '/composer/vendor/autoload.php');

        echo 'Start chrome', PHP_EOL;
        $factory = new \HeadlessChromium\BrowserFactory('google-chrome');
        $browser = $factory->createBrowser([
            'headless' => true,
            'noSandbox' => true,
            'keepAlive' => false,
            'windowSize' => [1280, 960],
            'sendSyncDefaultTimeout' => 45000
        ]);
        echo 'Started chrome', PHP_EOL;

        while (1) {
            $queue = clone $queueOriginal;
            $queue->getRowFromDbAndFill([
                'action_id' => QueueModel::ACTION_ID_SCREENSHOT,
                'status_id' => QueueModel::STATUS_CREATED,
            ]);

            if (!$queue->id) {
                sleep(1);
                continue;
            }

            $queue->status_id = QueueModel::STATUS_STARTED;
            $queue->start_time = date("Y-m-d H:i:s");
            $queue->save();


            $project = (new Project())->getById($queue->payload['project_id']);

            Screens::createFolder($project->id);

            $page = $browser->createPage();
            $page->navigate('https://' . $project->url)->waitForNavigation();
            $page->screenshot([
                'format'  => 'jpeg',
                'quality' => 95,
            ])->saveToFile(Screens::getOriginalJpgScreen($project->id));
            $page->close();

            Screens::makeThumbs($project->url, $project->id);

            Investment::refreshMViews();

            $message = new SendPhotoRequest([
                'chat_id' => \Config::TELEGRAM_MY_ID,
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
}
