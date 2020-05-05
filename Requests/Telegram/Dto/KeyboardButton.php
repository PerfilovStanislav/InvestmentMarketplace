<?php

namespace Requests\Telegram\Dto;

use Core\AbstractEntity;

/**
 * @property string $text
 * @property array  $callback_data
 */
class KeyboardButton extends AbstractEntity {

    protected static array
        $properties = [
            'text'          => [self::TYPE_STRING, []],
            'callback_data' => [self::TYPE_JSON,   []],
        ];

}