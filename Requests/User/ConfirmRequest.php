<?php

namespace Requests\User;

use Core\AbstractEntity;
use Helpers\Validator;

/**
 * @property string $code
 */
class ConfirmRequest extends AbstractEntity {

    protected static array
        $properties = [
            'code' => [self::TYPE_STRING, [Validator::LENGTH => 64, Validator::REGEX => Validator::EN.Validator::NUM]],
        ];
}