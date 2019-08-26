<?php

namespace Requests\User;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;

/**
 * @property string $login
 * @property string $password
 * @property string $remember
 * @property string $authorizeType
 */
class AuthorizeRequest extends AbstractEntity implements EntityInterface {
    CONST
        LOGIN = 'login',
        EMAIL = 'email';

    protected $data;

    protected static
        $defaults = [
            'remember' => 'off'
        ],
        $properties = [
            'password' => [self::TYPE_STRING, [Validator::MIN => 3, Validator::MAX => 64]],
            'remember' => [self::TYPE_STRING, [Validator::IN => ['on', 'off']]],
        ];

    public function __construct(array $data = []) {
        $data += self::$defaults;
        if (mb_strpos($data['login'] ?? '', '@') > 0) {
            self::$properties += ['login' => [self::TYPE_STRING, [Validator::MIN => 5, Validator::REGEX => Validator::EMAIL, Validator::MAX => 64]]];
            $this->authorizeType = self::EMAIL;
        } else {
            self::$properties += ['login' => [self::TYPE_STRING, [Validator::MIN => 2, Validator::REGEX => Validator::LOGIN, Validator::MAX => 32]]];
            $this->authorizeType = self::LOGIN;
        }
        parent::__construct($data);
    }
}