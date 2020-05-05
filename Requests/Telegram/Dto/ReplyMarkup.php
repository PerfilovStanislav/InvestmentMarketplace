<?php

namespace Requests\Telegram\Dto;

use Core\AbstractEntity;

/**
 * @property InlineKeyboard    $inline_keyboard
 */
class ReplyMarkup extends AbstractEntity {

    protected static array
        $properties = [
            'inline_keyboard' => [self::TYPE_DTO_ARRAY, KeyboardRow::class],
        ];
}