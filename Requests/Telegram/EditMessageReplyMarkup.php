<?php

namespace Requests\Telegram;

use Core\AbstractEntity;
use Models\Constant\TelegramParseMode;

/**
 * @property int    $chat_id
 * @property int    $message_id
 * @property string $inline_message_id
 * @property array  $reply_markup
 */
class EditMessageReplyMarkup extends AbstractEntity {

    protected static array
        $properties = [
            'chat_id'           => [self::TYPE_INT,    []],
            'message_id'        => [self::TYPE_INT,    []],
            'inline_message_id' => [self::TYPE_STRING, []],
            'reply_markup'      => [self::TYPE_JSON,   []],
        ];

    public static function getDefaults(): array {
        return [
            'parse_mode' => TelegramParseMode::MARKDOWN,
        ];
    }
}