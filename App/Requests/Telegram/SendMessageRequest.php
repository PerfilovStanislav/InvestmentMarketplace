<?php

namespace App\Requests\Telegram;

use App\Core\AbstractEntity;
use App\Helpers\Validator;
use App\Models\Constant\TelegramParseMode;

/**
 * @property int    $chat_id
 * @property string $text
 * @property string $parse_mode
 */
class SendMessageRequest extends AbstractEntity {

    protected static array
        $properties = [
            'chat_id'               => [self::TYPE_INT,        []],
            'text'                  => [self::TYPE_STRING,     [Validator::MIN => 1]],
            'reply_markup'          => [self::TYPE_JSON,       [Validator::MIN => 1]     , self::TYPE_NOT_REQUIRED],
            'parse_mode'            => [self::TYPE_CONSTANTS,  TelegramParseMode::class  , self::TYPE_NOT_REQUIRED],
            'disable_notification'  => [self::TYPE_BOOL,       []],
        ];

    public static function getDefaults(): array {
        return [
            'parse_mode' => TelegramParseMode::MARKDOWN,
        ];
    }
}
