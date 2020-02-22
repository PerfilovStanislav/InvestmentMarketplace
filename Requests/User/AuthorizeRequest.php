<?php

namespace Requests\User;

use Core\AbstractEntity;
use Helpers\Validator;
use Models\Table\User;

/**
 * @property string $login
 * @property string $password
 * @property string $remember
 */
class AuthorizeRequest extends AbstractEntity {

    protected static array
        $properties = [
            'password' => [self::TYPE_STRING, [Validator::MIN => 3, Validator::MAX => 64]],
            'remember' => [self::TYPE_STRING, [Validator::IN => ['on', 'off']]],
        ];

    public static function getDefaults(): array {
        return [
            'remember' => 'off'
        ];
    }

    public function __construct(array $data = []) {
        static::$properties += User::getPropertyByKey('login');
        parent::__construct($data);
    }
}