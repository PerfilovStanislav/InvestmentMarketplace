<?php

namespace Models\Table {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Traits\Model;

    /**
     * @property int    $id
     * @property int    $user_id
     * @property int    $lang_id
     * @property string $photo
     */
    class UserParam extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;
        
        private static $table = 'user_params';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'      => [self::TYPE_INT, [Validator::MIN => 1]],
                'user_id' => [self::TYPE_INT, [Validator::MIN => 1]],
                'lang_id' => [self::TYPE_INT, [Validator::MIN => 1]],
                'photo'   => [self::TYPE_INT, [Validator::MIN => 1]],
            ];
    }
}
