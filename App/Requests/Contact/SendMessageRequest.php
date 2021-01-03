<?php

namespace App\Requests\Contact;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;

/**
 * @property string $name
 * @property string $message
 */
class SendMessageRequest extends AbstractRequest {

    protected static array
        $properties = [
            'name'    => [self::TYPE_STRING, [Validator::MIN => 1, Validator::MAX => 100, Validator::REGEX => Validator::EN_FULL_NAME]],
            'message' => [self::TYPE_STRING, [Validator::MIN => 1, Validator::MAX => 2500]],
        ];

    public static function getDefaults(): array
    {
        return []
            + (CurrentUser()->is_authorized ? ['name' => CurrentUser()->user->name] : [])
        ;
    }
}
