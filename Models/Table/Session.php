<?php

namespace Models\Table;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\ModelInterface;
use Traits\Model;

/**
 * @property int $id
 * @property string $uid
 * @property string $ip
 * @property string $http_referer
 */
class Session extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'session';

    protected static array
        $properties = [
            'id'            => [self::TYPE_INT,    [Validator::MIN => 1]],
            'uid'           => [self::TYPE_STRING, [Validator::MIN => 26, Validator::MAX => 32]],
            'ip'            => [self::TYPE_STRING, [Validator::REGEX => Validator::IP]],
            'http_referer'  => [self::TYPE_STRING, [Validator::MAX => 1024], self::TYPE_NULLABLE],
        ];
}
