<?php

namespace Controllers;

use Requests\Telegram\SendMessageRequest;
use Requests\Telegram\SetWebhookRequest;

class Telegram {

    public function setWebhook() {
        $request = new SetWebhookRequest([
            'url'             => 'https://richinme.com/Telegram/getWebhook/token/' . \Config::TELEGRAM_GET_WEBHOOK_KEY,
            'certificate'     => '/etc/ssl/richinme_com.pem',
            'max_connections' => 20,
        ]);
        $result = App()->telegram()->setWebhook($request);

        $this->getWebhook('xxx', $result);
    }

    public function getWebhook(string $token, $params = []) {
        $request = new SendMessageRequest([
            'chat_id'     => \Config::TELEGRAM_MY_ID,
            'text'        => is_string($params) ? $params : json_encode($params, JSON_PRETTY_PRINT),
        ]);
        App()->telegram()->sendMessage($request);
    }
}