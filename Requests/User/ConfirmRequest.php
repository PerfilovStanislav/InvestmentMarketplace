<?php

namespace Requests\User;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;

/**
 * @property string $code
 */
class ConfirmRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $properties = [
            'code' => [self::TYPE_STRING, [Validator::LENGTH => 64, Validator::REGEX => Validator::EN.Validator::NUM]],
        ];
}