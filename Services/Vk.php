<?php

namespace Services;

use Libraries\Screens;
use Models\Table\Language;
use Models\Table\Project;
use Models\Table\ProjectLang;
use VK\Client\VKApiClient;

class Vk
{
    public function sendToMarket(Project $project, ProjectLang $projectLang, int $groupID)
    {
        $client = new VKApiClient();

        $uploadServer = $client->photos()->getMarketUploadServer(\Config::VK_USER_TOKEN, [
            'group_id' => $groupID,
            'main_photo' => 1,
        ]);

        $upload = $client->getRequest()->upload(
            $uploadServer['upload_url'],
            'file',
            Screens::getOriginalJpgScreen($project->id)
        );

        $marketPhoto = $client->photos()->saveMarketPhoto(\Config::VK_USER_TOKEN, [
            'group_id'  => $groupID,
            'photo'     => $upload['photo'],
            'server'    => $upload['server'],
            'hash'      => $upload['hash'],
            'crop_data' => $upload['crop_data'],
            'crop_hash' => $upload['crop_hash']
        ]);

        $language = (new Language())->getById($projectLang->lang_id);

        return $client->market()->add(\Config::VK_USER_TOKEN, [
            'owner_id' => -$groupID,
            'main_photo_id' => $marketPhoto[0]['id'],
            'name' => $project->name,
            'description' => str_replace(['<\br>', '< br>', '<br>'], '', $projectLang->description),
            'category_id' => 1208,
            'price' => 1,
            'url' => sprintf('%s/Investment/details/site/%s/lang/%s', SITE, $project->url, $language->shortname),
        ]);
    }
}
