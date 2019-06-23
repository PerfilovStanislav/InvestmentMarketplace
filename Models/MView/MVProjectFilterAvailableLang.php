<?php

namespace Models\MView {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;

    /**
     * @property int $lang_id
     * @property int $status_id
     * @property int $cnt
     */
    class MVProjectFilterAvailableLang extends AbstractEntity implements EntityInterface {

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'lang_id'   => [self::TYPE_INT, [Validator::MIN  => 1]],
                'status_id' => [self::TYPE_INT, [Validator::MIN  => 1]],
                'cnt'       => [self::TYPE_INT, [Validator::MIN  => 1]],
            ];
    }
}
