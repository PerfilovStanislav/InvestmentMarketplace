<?php

namespace App\Requests\User;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Models\Table\User;

/**
 * @property string $login
 * @property string $name
 * @property string $password
 */
class RegistrationRequest extends AbstractRequest {

    protected static array
        $properties = [
            'password' => [self::TYPE_STRING, [Validator::MIN => 3, Validator::MAX => 64]],
        ];

    public function __construct(array $data = []) {
        static::$properties += User::getPropertyByKey('login');
        static::$properties += User::getPropertyByKey('name');
        parent::__construct($data);
    }
}