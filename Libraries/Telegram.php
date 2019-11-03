<?php

namespace Libraries;

use Requests\Telegram\{
    SendMessageRequest,
    SendPhotoRequest,
};
use Helpers\Errors;

class Telegram
{
    private CONST
        TOKEN = '859596987:AAGke6EgacSb9jpKvftb53UUF_M9uxkU7Q4',
        TELEGRAM_API = 'https://api.telegram.org/bot' . self::TOKEN;

    CONST MY_TELEGRAM_ID = 228245070;

    private static function send(string $method, array $params) {
        $ch = curl_init(self::TELEGRAM_API . '/' . $method);

        curl_setopt_array($ch, [
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $params,
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

        $params = [
            'chat_id' => $request->chat_id,
            'text' => $request->text,
        ];

        return self::send('sendMessage', $params);
    }

    public static function sendPhoto(SendPhotoRequest $request) {
        Errors::exitIfExists();

        $params = [
            'chat_id' => $request->chat_id,
            'caption' => $request->caption,
            'photo'   => $request->photo,
        ];

        return self::send('sendPhoto', $params);
    }

}