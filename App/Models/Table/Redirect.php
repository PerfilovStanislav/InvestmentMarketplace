<?php

namespace App\Models\Table;

use App\Core\AbstractEntity;
use App\Helpers\Validator;
use App\Interfaces\EntityInterface;
use App\Interfaces\ModelInterface;
use App\Traits\Model;

/**
 * @property int    $id
 * @property string $date_create
 * @property int    $user_id
 * @property int    $project_id
 * @property int    $session_id
 */
class Redirect extends AbstractEntity implements EntityInterface , ModelInterface {
    use Model;

    private static string $table = 'redirect';

    protected static array
        $properties = [
            'id'          => [self::TYPE_INT,      [Validator::MIN => 1]],
            'date_create' => [self::TYPE_DATETIME, []],
            'user_id'     => [self::TYPE_INT,      [], self::TYPE_NULLABLE],
            'project_id'  => [self::TYPE_INT,      []],
            'session_id'  => [self::TYPE_INT,      [Validator::MIN => 1]],
        ];
}
