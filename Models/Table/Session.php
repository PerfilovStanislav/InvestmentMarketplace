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
     * @property int $id
     * @property string $uid
     * @property string $ip
     */
    class Session extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'session';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'  => [self::TYPE_INT,    [Validator::MIN => 1]],
                'uid' => [self::TYPE_STRING, [Validator::LENGTH => 26]],
                'ip'  => [self::TYPE_STRING, [Validator::REGEX => Validator::IP]],
            ];
    }
}
