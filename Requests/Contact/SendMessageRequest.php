<?php

namespace Requests\Contact;

use Core\AbstractEntity;
use Helpers\Validator;

/**
 * @property string $name
 * @property string $message
 */
class SendMessageRequest extends AbstractEntity {

    protected static array
        $properties = [
            'name'    => [self::TYPE_STRING, [Validator::MIN => 1, Validator::MAX => 100, Validator::REGEX => Validator::EN_FULL_NAME]],
            'message' => [self::TYPE_STRING, [Validator::MIN => 1, Validator::MAX => 2500]],
        ];
}
