<?php

namespace App\Models\MView;

use App\Core\AbstractEntity;
use App\Helpers\Validator;

/**
 * @property int $status_id
 * @property int $cnt
 */
class MVProjectCount extends AbstractEntity {
    protected static array
        $properties = [
            'status_id' => [self::TYPE_INT, [Validator::MIN  => 1]],
            'cnt'       => [self::TYPE_INT, [Validator::MIN  => 1]],
        ];
}
