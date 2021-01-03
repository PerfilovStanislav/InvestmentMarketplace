<?php

namespace App\Models\Table;

use App\Core\AbstractEntity;
use App\Helpers\Validator;
use App\Interfaces\ModelInterface;
use App\Traits\Model;

/**
 * @property int    $id
 * @property string $name
 * @property int    $pos
 */
class Payment extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'payments';

    protected static array
        $properties = [
            'id'   => [self::TYPE_INT,    [Validator::MIN => 1]],
            'name' => [self::TYPE_STRING, []],
            'pos'  => [self::TYPE_INT,    []],
        ];
}
