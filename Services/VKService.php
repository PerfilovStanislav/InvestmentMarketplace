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

    public function sendToWall(int $langId, string $pathToFile, string $url, string $description, string $projectName)
    {
        $client = new VKApiClient();

        $uploadServer = $client->photos()->getWallUploadServer(\Config::VK_USER_TOKEN, [
            'group_id' => VKMapper::getGroupId($langId),
        ]);

        $upload = $client->getRequest()->upload(
            $uploadServer['upload_url'],
            'file',
            $pathToFile
        );

        $wallPhoto = $client->photos()->saveWallPhoto(\Config::VK_USER_TOKEN, [
            'group_id'  => VKMapper::getGroupId($langId),
            'photo'     => $upload['photo'],
            'server'    => $upload['server'],
            'hash'      => $upload['hash'],
            'latitude'  => 59.935944,
            'longitude' => 30.324097,
            'caption'   => "$projectName\n$description",
        ]);

        $params = [
            'owner_id'      => -VKMapper::getGroupId($langId),
            'message'       => "$projectName\n$description",
            'guid'          => mt_rand(1, PHP_INT_MAX),
            'copyright'     => 'https://richinme.com/',
            'attachments'   => sprintf('photo%d_%d,%s', $wallPhoto[0]['owner_id'], $wallPhoto[0]['id'], $url),
            'from_group'    => 1,
            'v'             => '5.122',
        ];

        return $client->wall()->post(\Config::VK_USER_TOKEN, $params);
    }
}
