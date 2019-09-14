<?php

namespace Models\Table {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;
    use Interfaces\ModelInterface;
    use Models\Constant\UserStatus;
    use Traits\Model;

    /**
     * @property int    $id
     * @property string $login
     * @property string $name
     * @property string $password
     * @property int    $status_id
     * @property string $date_create
     * @property int    $lang_id
     * @property bool   $has_photo
     */
    class User extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'users';

        protected $data;

        protected static
            $defaults = null,
            $arrayable = ['id', 'login', 'name', 'status_id', 'has_photo', 'lang_id'],
            $properties = [
                'id'          => [self::TYPE_INT,      [Validator::MIN => 1]],
                'login'       => [self::TYPE_STRING,   [Validator::MIN => 2, Validator::REGEX => Validator::LOGIN, Validator::MAX => 32]],
                'name'        => [self::TYPE_STRING,   [Validator::MIN => 2, Validator::MAX => 64]],
                'password'    => [self::TYPE_STRING,   [Validator::LENGTH => 53, Validator::REGEX => Validator::HASH]],
                'status_id'   => [self::TYPE_INT,      [Validator::IN => UserStatus::class]],
                'date_create' => [self::TYPE_DATETIME, []],
                'lang_id'     => [self::TYPE_INT,      [Validator::MIN => 183, Validator::MAX => 364]],
                'has_photo'   => [self::TYPE_BOOL,     []],
            ];
    }
}
