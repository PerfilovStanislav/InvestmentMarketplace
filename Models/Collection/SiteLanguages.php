<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Helpers\Locales\SiteLanguageCollection;
use Models\Table\Language;
use Traits\Instance;
use Traits\IteratorTrait;

/**
 * @property Language[] $this
 */
class SiteLanguages extends AbstractEntity implements \Iterator {
    use IteratorTrait;
    use Instance;

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, Language::class, 'shortname'],
        ];

    protected function __construct() {
        $this->fillCollection(Language::setTable()->select(
            ['id' => array_keys(SiteLanguageCollection::LANGUAGES)],
            Language::getPropertyKeys())
        );
    }
}
