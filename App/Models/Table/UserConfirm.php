<?php

namespace App\Models\Table;

use App\Core\AbstractEntity;
use App\Helpers\Validator;
use App\Interfaces\ModelInterface;
use App\Traits\Model;

/**
 * @property int    $id
 * @property int    $user_id
 * @property string $code
 */
class UserConfirm extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'user_confirm';

    protected static array
        $properties = [
            'id'      => [self::TYPE_INT,    [Validator::MIN => 1]],
            'user_id' => [self::TYPE_INT,    [Validator::MIN => 1]],
            'code'    => [self::TYPE_STRING, [Validator::LENGTH => 64, Validator::REGEX => Validator::EN.Validator::NUM]],
        ];
}
