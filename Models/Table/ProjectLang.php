<?php

namespace Models\Table;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\ModelInterface;
use Traits\Model;

/**
 * @property int    $id
 * @property int    $project_id
 * @property int    $lang_id
 * @property string $description
 */
class ProjectLang extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'project_lang';

    protected static array
        $properties = [
            'id'          => [self::TYPE_INT,    [Validator::MIN  => 1]],
            'project_id'  => [self::TYPE_INT,    [Validator::MIN  => 1]],
            'lang_id'     => [self::TYPE_INT,    [Validator::MIN  => 1]],
            'description' => [self::TYPE_STRING, [Validator::MIN  => 1]],
        ];
}
