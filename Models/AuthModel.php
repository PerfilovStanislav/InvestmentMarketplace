<?php

namespace Models {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;
    use Models\Constant\UserStatus;
    use Models\Table\User;
    use Traits\Instance;

    /**
     * @property User user
     * @property bool is_authorized
     * @property int  session_id
     */
    class AuthModel extends AbstractEntity implements EntityInterface {
        use Instance;

        protected $data;

        protected static
            $properties = [
                'user'          => [self::TYPE_DTO,  User::class],
                'is_authorized' => [self::TYPE_BOOL, []],
                'session_id'    => [self::TYPE_INT,  [Validator::MIN => 1]],
            ];

        public function getUserAvatar() : ?string {
            $path = '/assets/%s/%s.' . (WEBP ? 'webp' : 'jpg');
            if (!$this->is_authorized) {
                return sprintf($path, 'img/avatars', ($this->session_id-1)%30+1);
            }
            if ($this->user->has_photo) {
                return sprintf($path, 'user', $this->user->id);
            }
            return sprintf($path, 'img/avatars', ($this->user->id-1)%30+1);
        }

        public static function getUserId() : ?int {
            return static::getInstance()->is_authorized ? static::getInstance()->user->id : null;
        }

        public static function getStatusId() : ?int {
            return static::getInstance()->is_authorized ? static::getInstance()->user->status_id : null;
        }

        public static function isAdmin() : bool {
            return static::getStatusId() === UserStatus::ADMIN;
        }
    }

}
