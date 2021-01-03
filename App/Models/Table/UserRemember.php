<?php

namespace App\Models\Table;

use App\Core\AbstractEntity;
use App\Helpers\Validator;
use App\Interfaces\ModelInterface;
use App\Traits\Model;

/**
 * @property int    $id
 * @property int    $user_id
 * @property string $hash
 * @property string $ip
 */
class UserRemember extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'user_remember';

    protected static array
        $properties = [
            'id'        => [self::TYPE_INT,    [Validator::MIN => 1]],
            'user_id'   => [self::TYPE_INT,    [Validator::MIN => 1]],
            'hash'      => [self::TYPE_STRING, [Validator::LENGTH => 53]],
            'ip'        => [self::TYPE_STRING, [Validator::REGEX => Validator::IP]],
        ];
}
