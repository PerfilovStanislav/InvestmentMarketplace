<?php

namespace Models\MView {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;

    /**
     * @property int    $id
     */
    class ProjectSearch extends AbstractEntity implements EntityInterface {

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id' => [self::TYPE_INT, [Validator::MIN => 1]],
            ];
    }
}
