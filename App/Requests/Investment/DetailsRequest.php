<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;

/**
 * @property string $site
 * @property string $lang
 */
class DetailsRequest extends AbstractRequest {

    protected static array
        $properties = [
            'site' => [self::TYPE_STRING, [Validator::REGEX => Validator::SITE_URI]],
            'lang' => [self::TYPE_STRING, [Validator::REGEX => Validator::EN]],
        ];

    public static function getDefaults(): array {
        return [
            'lang' => App()->locale()->getLanguage(),
        ];
    }

}