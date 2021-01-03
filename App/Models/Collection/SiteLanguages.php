<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Helpers\Locales\SiteLanguageCollection;
use App\Models\Table\Language;
use App\Traits\Instance;
use App\Traits\IteratorTrait;

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
