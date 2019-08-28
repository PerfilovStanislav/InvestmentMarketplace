<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\MView\MVProjectLang;
    use Traits\MView;

    /**
     * @var MVProjectLang[] $this
     */
    class MVProjectLangs extends AbstractEntity implements EntityInterface, ModelInterface {
        use MView;

        private static $table = 'mv_projectlangs';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, MVProjectLang::class, 'id'],
            ];

        public function __construct(array $where) {
            $this->fillCollection(self::getDb()->select($where, MVProjectLang::getPropertyKeys()));
        }
    }
}
