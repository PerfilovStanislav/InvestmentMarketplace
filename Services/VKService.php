<?php

namespace Services;

use Mappers\VKMapper;
use VK\Client\VKApiClient;

class VKService
{
    public function sendToMarket(int $langId, string $pathToFile, string $url, string $description, string $projectName)
    {
        $client = new VKApiClient();

        $uploadServer = $client->photos()->getMarketUploadServer(\Config::VK_USER_TOKEN, [
            'group_id' => VKMapper::getGroupId($langId),
            'main_photo' => 1,
        ]);

        $upload = $client->getRequest()->upload(
            $uploadServer['upload_url'],
            'file',
            $pathToFile
        );

        $marketPhoto = $client->photos()->saveMarketPhoto(\Config::VK_USER_TOKEN, [
            'group_id'  => VKMapper::getGroupId($langId),
            'photo'     => $upload['photo'],
            'server'    => $upload['server'],
            'hash'      => $upload['hash'],
            'crop_data' => $upload['crop_data'],
            'crop_hash' => $upload['crop_hash']
        ]);

        return $client->market()->add(\Config::VK_USER_TOKEN, [
            'owner_id' => -VKMapper::getGroupId($langId),
            'main_photo_id' => $marketPhoto[0]['id'],
            'name' => $projectName,
            'description' => $description,
            'category_id' => 1208,
            'price' => 10,
            'url' => $url,
        ]);
    }
}
