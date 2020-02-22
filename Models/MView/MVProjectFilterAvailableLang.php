<?php

namespace Models\MView;

use Core\AbstractEntity;
use Helpers\Validator;

/**
 * @property int $lang_id
 * @property int $status_id
 * @property int $cnt
 */
class MVProjectFilterAvailableLang extends AbstractEntity {

    protected static array
        $properties = [
            'lang_id'   => [self::TYPE_INT, [Validator::MIN  => 1]],
            'status_id' => [self::TYPE_INT, [Validator::MIN  => 1]],
            'cnt'       => [self::TYPE_INT, [Validator::MIN  => 1]],
        ];
}
