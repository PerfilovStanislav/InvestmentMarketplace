<?php

namespace Models\MView;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\ModelInterface;
use Traits\Model;

/**
 * @property int $id
 * @property int $lang_id
 */
class MVProjectLang extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'mv_projectlangs';

    protected static array
        $properties = [
            'id'         => [self::TYPE_INT,   [Validator::MIN  => 1]],
            'lang_id'    => [self::TYPE_INT_ARRAY, []],
        ];
}
