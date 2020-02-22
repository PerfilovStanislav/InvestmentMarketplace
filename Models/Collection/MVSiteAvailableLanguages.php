<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\Table\Language;
use Traits\Instance;
use Traits\IteratorTrait;
use Traits\Model;

/**
 * @property Language[] $this
 */
class MVSiteAvailableLanguages extends AbstractEntity implements ModelInterface, \Iterator {
    use Model;
    use IteratorTrait;
    use Instance;

    private static string $table = 'MV_SiteAvailableLanguages';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, Language::class, 'shortname'],
        ];

    protected function __construct() {
        $this->fillCollection(self::getDb()->select(null, Language::getPropertyKeys()));
    }
}
