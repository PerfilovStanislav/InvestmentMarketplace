<?php

namespace Requests\Telegram\Dto;

use Core\AbstractEntity;

/**
 * @property string $file_id
 * @property string $file_unique_id
 * @property int    $file_size
 * @property int    $width
 * @property int    $height
 */
class Photo extends AbstractEntity {

    protected static array
        $properties = [
            'file_id'        => [self::TYPE_STRING, []],
            'file_unique_id' => [self::TYPE_STRING, []],
            'file_size'      => [self::TYPE_INT,    []],
            'width'          => [self::TYPE_INT,    []],
            'height'         => [self::TYPE_INT,    []],
        ];
}