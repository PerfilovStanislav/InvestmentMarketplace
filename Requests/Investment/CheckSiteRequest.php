<?php

namespace Requests\Investment;

use Requests\AbstractRequest;
use Helpers\Validator;

/**
 * @property string $website
 */
class CheckSiteRequest extends AbstractRequest {

    protected static array
        $properties = [
            'website' => [self::TYPE_STRING, [
                Validator::MIN => 1,
                Validator::MAX => 128,
                Validator::REGEX => Validator::REF_SITE_URL,
            ]],
        ];
}