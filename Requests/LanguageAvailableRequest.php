<?php

namespace Requests;

use Core\AbstractEntity;
use Helpers\Validator;

/**
 * @property string $lang
 */
class LanguageAvailableRequest extends AbstractEntity {

    protected static array
        $properties;

    public function __construct(array $data = []) {
        self::$properties = [
            'lang' => [self::TYPE_STRING,
                [
                    Validator::REGEX => Validator::EN,
                    Validator::IN => App()->siteLanguages()->getUniqueValuesByKey('shortname')
                ]
            ],
        ];
        $this->fromArray($data);
        Error()->exitIfExists();
    }
}