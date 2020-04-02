<?php

namespace Requests\Telegram;

use Core\AbstractEntity;
use Helpers\Validator;
use Models\Constant\TelegramParseMode;

/**
 * @property int    $chat_id
 * @property string $text
 * @property string $parse_mode
 */
class SendMessageRequest extends AbstractEntity {

    protected static array
        $properties = [
            'chat_id'     => [self::TYPE_INT,        []],
            'text'        => [self::TYPE_STRING,     [Validator::MIN => 1]],
            'parse_mode'  => [self::TYPE_CONSTANTS,  TelegramParseMode::class],
        ];

    public static function getDefaults(): array {
        return [
            'parse_mode' => TelegramParseMode::MARKDOWN,
        ];
    }
}
