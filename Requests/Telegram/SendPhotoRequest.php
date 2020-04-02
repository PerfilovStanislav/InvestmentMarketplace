<?php

namespace Requests\Telegram;

use Core\AbstractEntity;
use Helpers\Validator;
use Models\Constant\TelegramParseMode;

/**
 * @property int       $chat_id
 * @property string    $caption
 * @property string    $parse_mode
 * @property \CURLFile $photo
 */
class SendPhotoRequest extends AbstractEntity {

    protected static array
        $properties = [
            'chat_id'     => [self::TYPE_INT,        []],
            'photo'       => [self::TYPE_CURL_FILE,  [Validator::MIN => 1]],
            'parse_mode'  => [self::TYPE_CONSTANTS,  TelegramParseMode::class],
            'caption'     => [self::TYPE_STRING,     [Validator::MIN => 0]],
        ];

    public static function getDefaults(): array {
        return [
            'parse_mode' => TelegramParseMode::MARKDOWN,
        ];
    }
}