<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\MView\MVProjectSearch;
    use Traits\MView;

    /**
     * @var MVProjectSearch[] $this
     */
    class MVProjectSearchs extends AbstractEntity implements EntityInterface, ModelInterface {
        use MView;

        private static $table = 'MV_ProjectSearchs';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, MVProjectSearch::class, 'id'],
            ];

        public function __construct(array $where, int $limit) {
            $this->fillCollection(self::getDb()->select($where, MVProjectSearch::getPropertyKeys(), null, $limit));
        }
    }
}
