<?php

namespace App\Requests\Telegram;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Models\Constant\TelegramParseMode;

/**
 * @property int       $chat_id
 * @property string    $caption
 * @property array     $reply_markup
 * @property string    $parse_mode
 * @property \CURLFile $photo
 * @property int       $reply_to_message_id
 */
class SendPhotoRequest extends AbstractRequest {

    protected static array
        $properties = [
            'chat_id'              => [self::TYPE_INT,       []],
            'photo'                => [self::TYPE_CURL_FILE, [Validator::MIN => 1]],
            'parse_mode'           => [self::TYPE_CONSTANTS, TelegramParseMode::class   , self::TYPE_NOT_REQUIRED],
            'caption'              => [self::TYPE_STRING,    [Validator::MIN => 0]      , self::TYPE_NOT_REQUIRED],
            'reply_markup'         => [self::TYPE_JSON,      []                         , self::TYPE_NOT_REQUIRED],
            'reply_to_message_id'  => [self::TYPE_INT,       []                         , self::TYPE_NOT_REQUIRED],
            'disable_notification' => [self::TYPE_BOOL,      []                         , self::TYPE_NOT_REQUIRED],
        ];

    public static function getDefaults(): array {
        return [
            'parse_mode'           => TelegramParseMode::MARKDOWN,
            'disable_notification' => date('H') < 5 || date('H') > 18,
        ];
    }
}