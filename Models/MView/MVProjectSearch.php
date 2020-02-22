<?php

namespace Models\MView;

use Core\AbstractEntity;
use Helpers\Validator;

/**
 * @property int    $id
 */
class MVProjectSearch extends AbstractEntity {

    protected static array
        $properties = [
            'id' => [self::TYPE_INT, [Validator::MIN => 1]],
        ];
}
