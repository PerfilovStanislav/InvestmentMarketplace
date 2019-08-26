<?php

namespace Requests\User;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;

/**
 * @property string $login
 * @property string $name
 * @property string $email
 * @property string $password
 */
class RegistrationRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $properties = [
            'login'    => [self::TYPE_STRING, [Validator::MIN => 2, Validator::MAX => 32, Validator::REGEX => Validator::LOGIN]],
            'name'     => [self::TYPE_STRING, [Validator::MIN => 2, Validator::MAX => 64]],
            'email'    => [self::TYPE_STRING, [Validator::MIN => 5, Validator::MAX => 64, Validator::REGEX => Validator::EMAIL]],
            'password' => [self::TYPE_STRING, [Validator::MIN => 3, Validator::MAX => 64]],
        ];
}