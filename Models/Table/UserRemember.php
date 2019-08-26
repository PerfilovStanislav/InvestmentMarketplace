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
     * @property string $hash
     * @property string $ip
     */
    class UserRemember extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'user_remember';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'        => [self::TYPE_INT,    [Validator::MIN => 1]],
                'user_id'   => [self::TYPE_INT,    [Validator::MIN => 1]],
                'hash'      => [self::TYPE_STRING, [Validator::LENGTH => 53]],
                'ip'        => [self::TYPE_STRING, [Validator::REGEX => Validator::IP]],
            ];
    }
}
