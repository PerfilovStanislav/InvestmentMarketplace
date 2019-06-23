<?php

namespace Models\Table {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;

    /**
     * @property int    $id
     * @property string $name
     * @property string $shortname
     * @property string $own_name
     * @property string $flag
//     * @property int    $status_id
//     * @property int    $cnt
     */
    class Language extends AbstractEntity implements EntityInterface {

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'        => [self::TYPE_INT,    [Validator::MIN    => 1]],
                'name'      => [self::TYPE_STRING, [Validator::REGEX  => Validator::EN]],
                'shortname' => [self::TYPE_STRING, [Validator::LENGTH => 2]],
                'own_name'  => [self::TYPE_STRING, []],
                'flag'      => [self::TYPE_STRING, [Validator::LENGTH => 2]],
//                'status_id' => [self::TYPE_INT,    [Validator::MIN    => 1]],
//                'cnt'       => [self::TYPE_INT,    [Validator::MIN    => 1]],
            ];
    }
}
