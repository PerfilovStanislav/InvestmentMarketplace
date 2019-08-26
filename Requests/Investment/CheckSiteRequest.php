<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;

/**
 * @property string $website
 */
class CheckSiteRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties = [
            'website' => [self::TYPE_STRING, [
                Validator::MIN => 1,
                Validator::MAX => 128,
                Validator::REGEX => Validator::REF_SITE_URL,
            ]],
        ];
}