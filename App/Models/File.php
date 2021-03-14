<?php

namespace App\Models;

use App\Core\AbstractEntity;
use App\Helpers\Validator;

/**
 * @property string name
 * @property string type
 * @property string tmp_name
 * @property int    size
 * @property int    error
 */
class File extends AbstractEntity {
    protected static array
        $properties = [
            'name'          => [self::TYPE_STRING,  []],
            'type'          => [self::TYPE_STRING,  []],
            'tmp_name'      => [self::TYPE_STRING,  []],
            'size'          => [self::TYPE_INT,     [Validator::MIN => 1]],
            'error'         => [self::TYPE_INT,     []],
        ];
}
