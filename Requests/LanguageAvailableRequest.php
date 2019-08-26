<?php

namespace Requests;

use Core\AbstractEntity;
use Helpers\Locale;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Collection\MVSiteAvailableLanguages;
use Models\ProjectAvailableLangs;

/**
 * @property string $lang
 */
class LanguageAvailableRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties;

    public function __construct(array $data = []) {
        self::$properties = [
            'lang' => [self::TYPE_STRING,
                [
                    Validator::REGEX => Validator::EN,
                    Validator::IN => MVSiteAvailableLanguages::getInstance()->getUniqueValuesByKey('shortname')
                ]
            ],
        ];
        $this->fromArray($data);
    }
}