<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\EntityInterface;
    use Interfaces\ModelInterface;
    use Models\Table\Language;
    use Traits\Instance;
    use Traits\IteratorTrait;
    use Traits\Model;

    /**
     * @property Language[] $this
     */
    class MVSiteAvailableLanguages extends AbstractEntity implements EntityInterface, ModelInterface, \Iterator {
        use Model;
        use IteratorTrait;
        use Instance;

        private static $table = 'MV_SiteAvailableLanguages';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, Language::class, 'shortname'],
            ];

        public function __construct() {
            $this->fillCollection(self::getDb()->select(null, Language::getPropertyKeys()));
        }
    }
}
