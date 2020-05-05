<?php

namespace Libraries;

use Core\AbstractEntity;
use Requests\Telegram\{EditMessageReplyMarkup, SendMessageRequest, SendPhotoRequest, SetWebhookRequest};
use Traits\Instance;

class Telegram {
    use Instance;

    private CONST TELEGRAM_API = 'https://api.telegram.org/bot' . \Config::TELEGRAM_BOT_TOKEN;

    private function send(string $method, AbstractEntity $params):array {
        $ch = curl_init(self::TELEGRAM_API . '/' . $method);

        curl_setopt_array($ch, [
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $params->toArray(),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO         => '/etc/ssl/richinme_com.pem',
            CURLOPT_HTTPHEADER     => ['Content-Type:multipart/form-data'],
        ]);
        $result = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            dd($error);
        }

        return json_decode($result, true, 512, JSON_THROW_ON_ERROR);
    }

    public function sendMessage(SendMessageRequest $request) {
        return $this->send('sendMessage', $request);
    }

    public function sendPhoto(SendPhotoRequest $request) {
        Error()->exitIfExists();
        return $this->send('sendPhoto', $request);
    }

    public function editMessageReplyMarkup(EditMessageReplyMarkup $request) {
        Error()->exitIfExists();
        return $this->send('editMessageReplyMarkup', $request);
    }

    public function setWebhook(SetWebhookRequest $request) {
        Error()->exitIfExists();
        return $this->send('setWebhook', $request);
    }

}