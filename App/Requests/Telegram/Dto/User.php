<?php

namespace App\Requests\Telegram\Dto;

use App\Core\AbstractEntity;

/**
 * @property int    $id
 * @property int    $is_bot
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $language_code
 * @property string $type
 */
class User extends AbstractEntity {

    protected static array
        $properties = [
            'id'            => [self::TYPE_INT,    []],
            'is_bot'        => [self::TYPE_BOOL,   []],
            'first_name'    => [self::TYPE_STRING, []],
            'last_name'     => [self::TYPE_STRING, []],
            'username'      => [self::TYPE_STRING, []],
            'language_code' => [self::TYPE_STRING, []],
            'type'          => [self::TYPE_STRING, []],
        ];
}