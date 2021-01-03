<?php

namespace App\Requests\Telegram\Dto;

use App\Core\AbstractEntity;

/**
 * @property int     $id
 * @property User    $from
 * @property Message $message
 * @property int     $chat_instance
 * @property array   $data
 */
class CallbackQuery extends AbstractEntity {

    protected static array
        $properties = [
            'id'            => [self::TYPE_INT,  []],
            'from'          => [self::TYPE_DTO,  User::class],
            'message'       => [self::TYPE_DTO,  Message::class],
            'chat_instance' => [self::TYPE_INT,  []],
            'data'          => [self::TYPE_JSON, []],
        ];
}