<?php

namespace Libraries;

use Core\AbstractEntity;
use Requests\Telegram\{
    SendMessageRequest,
    SendPhotoRequest,
};
use Helpers\Errors;

class Telegram
{
    private CONST
        TOKEN = '',
        TELEGRAM_API = 'https://api.telegram.org/bot' . self::TOKEN;

    CONST MY_TELEGRAM_ID = 228245070;

    private static function send(string $method, AbstractEntity $params) {
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
//        $error = curl_error($ch);
        curl_close($ch);

        return $result;
    }

    public static function sendMessage(SendMessageRequest $request) {
        Errors::exitIfExists();
        return self::send('sendMessage', $request);
    }

    public static function sendPhoto(SendPhotoRequest $request) {
        Errors::exitIfExists();
        return self::send('sendPhoto', $request);
    }

}