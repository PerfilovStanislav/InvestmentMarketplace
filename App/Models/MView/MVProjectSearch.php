<?php

namespace App\Models\MView;

use App\Core\AbstractEntity;
use App\Helpers\Validator;

/**
 * @property int    $id
 */
class MVProjectSearch extends AbstractEntity {

    protected static array
        $properties = [
            'id' => [self::TYPE_INT, [Validator::MIN => 1]],
        ];
}
