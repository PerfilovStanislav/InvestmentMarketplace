<?php

namespace Controllers;

use Requests\Telegram\SendMessageRequest;
use Requests\Telegram\SetWebhookRequest;
use Libraries\Telegram as TelegramLibrary;

class Telegram
{
    public static function setWebhook()
    {
        $request = new SetWebhookRequest([
            'url'             => 'https://richinme.com/Telegram/getWebhook/token/' . \Config::GET_WEBHOOK_KEY,
            'certificate'     => '/etc/ssl/richinme_com.pem',
            'max_connections' => 20,
        ]);
        $result = TelegramLibrary::setWebhook($request);

        self::getWebhook('xxx', $result);
    }

    public static function getWebhook(string $token, $params = [])
    {
        $request = new SendMessageRequest([
            'chat_id'     => TelegramLibrary::MY_TELEGRAM_ID,
            'text'        => is_string($params) ? $params : json_encode($params, JSON_PRETTY_PRINT),
        ]);
        TelegramLibrary::sendMessage($request);
    }
}