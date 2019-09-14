<?php

namespace Requests\User;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Table\User;

/**
 * @property string $login
 * @property string $password
 * @property string $remember
 */
class AuthorizeRequest extends AbstractEntity implements EntityInterface {
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
        static::$properties += User::getPropertyByKey('login');
        $data += self::$defaults;
        parent::__construct($data);
    }
}