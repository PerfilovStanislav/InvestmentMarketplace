<?php

namespace App\Requests\User;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Models\Table\User;

/**
 * @property string $login
 * @property string $password
 * @property string $remember
 */
class AuthorizeRequest extends AbstractRequest {

    protected static array
        $properties = [
        'remember' => [self::TYPE_STRING, [Validator::IN => ['on', 'off']], self::TYPE_NOT_REQUIRED],
    ];

    public static function getDefaults(): array {
        return [
            'remember' => 'off'
        ];
    }

    public function __construct(array $data = []) {
        static::$properties += User::getPropertyByKey('login');
        static::$properties += RegistrationRequest::getPropertyByKey('password');
        parent::__construct($data);
    }
}