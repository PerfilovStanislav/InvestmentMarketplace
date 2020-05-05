<?php

namespace Requests\Telegram\Dto;

use Core\AbstractEntity;

/**
 * @property int     $message_id
 * @property User    $from
 * @property User    $chat
 * @property int     $date
 * @property Photo[] $photo
 * @property string  $caption
 * @property string  $reply_markup
 */
class Message extends AbstractEntity {

    protected static array
        $properties = [
            'message_id'   => [self::TYPE_INT,       []],
            'from'         => [self::TYPE_DTO,       User::class],
            'chat'         => [self::TYPE_DTO,       User::class],
            'date'         => [self::TYPE_INT,       []],
            'photo'        => [self::TYPE_DTO_ARRAY, Photo::class, 'file_unique_id'],
            'caption'      => [self::TYPE_STRING,    []],
            'reply_markup' => [self::TYPE_DTO,       ReplyMarkup::class],
        ];
}