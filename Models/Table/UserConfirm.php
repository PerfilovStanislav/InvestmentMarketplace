<?php

namespace Models\Table {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;
    use Interfaces\ModelInterface;
    use Traits\Model;

    /**
     * @property int    $id
     * @property int    $user_id
     * @property string $code
     */
    class UserConfirm extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'user_confirm';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'      => [self::TYPE_INT,    [Validator::MIN => 1]],
                'user_id' => [self::TYPE_INT,    [Validator::MIN => 1]],
                'code'    => [self::TYPE_STRING, [Validator::LENGTH => 64, Validator::REGEX => Validator::EN.Validator::NUM]],
            ];
    }
}
