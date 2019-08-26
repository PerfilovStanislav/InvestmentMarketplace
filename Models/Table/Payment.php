<?php

namespace Models\Table {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;

    /**
     * @property int    $id
     * @property string $name
     * @property int    $pos
     */
    class Payment extends AbstractEntity implements EntityInterface {

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'   => [self::TYPE_INT,    [Validator::MIN => 1]],
                'name' => [self::TYPE_STRING, []],
                'pos'  => [self::TYPE_INT,    []],
            ];
    }
}
