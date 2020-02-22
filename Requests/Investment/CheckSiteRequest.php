<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Validator;

/**
 * @property string $website
 */
class CheckSiteRequest extends AbstractEntity {

    protected static array
        $properties = [
            'website' => [self::TYPE_STRING, [
                Validator::MIN => 1,
                Validator::MAX => 128,
                Validator::REGEX => Validator::REF_SITE_URL,
            ]],
        ];
}