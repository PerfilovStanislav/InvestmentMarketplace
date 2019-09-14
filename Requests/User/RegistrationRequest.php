<?php

namespace Requests\User;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Table\User;

/**
 * @property string $login
 * @property string $name
 * @property string $password
 */
class RegistrationRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $properties = [
            'password' => [self::TYPE_STRING, [Validator::MIN => 3, Validator::MAX => 64]],
        ];

    public function __construct(array $data = []) {
        static::$properties += User::getPropertyByKey('login');
        static::$properties += User::getPropertyByKey('name');
        parent::__construct($data);
    }
}