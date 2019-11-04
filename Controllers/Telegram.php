<?php

namespace Controllers;

use Requests\Telegram\SendMessageRequest;
use Requests\Telegram\SetWebhookRequest;
use Libraries\Telegram as TelegramLibrary;

class Telegram
{
    public static function setWebhook(string $token, array $params = [])
    {
        $request = new SetWebhookRequest([
            'url'             => 'https://richinme.com/Telegram/getWebhook/token/' . \Config::GET_WEBHOOK_KEY,
            'certificate'     => '/etc/ssl/richinme_com.pem',
            'max_connections' => 20,
        ]);
        TelegramLibrary::setWebhook($request);
    }

    public static function getWebhook(string $token, array $params = [])
    {
        $request = new SendMessageRequest([
            'chat_id'     => TelegramLibrary::MY_TELEGRAM_ID,
            'text'        => json_encode($params, JSON_PRETTY_PRINT),
        ]);
        TelegramLibrary::sendMessage($request);
    }
}