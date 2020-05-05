<?php

namespace Services;

use Controllers\Investment;
use DiDom\Document;
use Exceptions\ErrorException;
use Libraries\Screens;
use Models\Constant\ProjectStatus;
use Models\Table\Project;
use Models\Table\Queue;
use Requests\Investment\ChangeStatusRequest;
use Requests\Investment\ReloadScreenshotRequest;

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

        require(ROOT . '/vendor/autoload.php');
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
}