<?php

namespace Models\Table;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\ModelInterface;
use Traits\Model;

/**
 * @property int    $id
 * @property string $name
 * @property string $shortname
 * @property string $own_name
 * @property string $flag
 */
class Language extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'languages';

    protected static array
        $properties = [
            'id'        => [self::TYPE_INT,    [Validator::MIN    => 1]],
            'name'      => [self::TYPE_STRING, [Validator::MIN    => 1]],
            'shortname' => [self::TYPE_STRING, [Validator::LENGTH => 2]],
            'own_name'  => [self::TYPE_STRING, [Validator::MIN    => 1]],
            'flag'      => [self::TYPE_STRING, [Validator::LENGTH => 2]],
        ];
}
