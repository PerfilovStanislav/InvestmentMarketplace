<?php

namespace Services;

use Libraries\Screens;
use VK\Client\VKApiClient;

class Vk
{
    public function sendToMarket(int $projectId, string $title, string $description)
    {
        $client = new VKApiClient();

        $uploadServer = $client->photos()->getMarketUploadServer(\Config::VK_USER_TOKEN, [
            'group_id' => \Config::VK_GROUP,
            'main_photo' => 1,
        ]);

        $upload = $client->getRequest()->upload(
            $uploadServer['upload_url'],
            'file',
            Screens::getOriginalJpgScreen($projectId)
        );

        $marketPhoto = $client->photos()->saveMarketPhoto(\Config::VK_USER_TOKEN, [
            'group_id'  => \Config::VK_GROUP,
            'photo'     => $upload['photo'],
            'server'    => $upload['server'],
            'hash'      => $upload['hash'],
            'crop_data' => $upload['crop_data'],
            'crop_hash' => $upload['crop_hash']
        ]);

        return $client->market()->add(\Config::VK_USER_TOKEN, [
            'owner_id' => -\Config::VK_GROUP,
            'main_photo_id' => $marketPhoto[0]['id'],
            'name' => $title,
            'description' => $description,
            'category_id' => 1208,
            'price' => 1,
        ]);
    }
}
