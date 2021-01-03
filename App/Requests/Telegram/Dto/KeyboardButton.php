<?php

namespace App\Requests\Telegram\Dto;

use App\Core\AbstractEntity;

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