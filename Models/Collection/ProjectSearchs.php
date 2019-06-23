<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\MView\ProjectSearch;
    use Traits\Model;

    /**
     * @var ProjectSearch[] $this
     */
    class ProjectSearchs extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'MV_ProjectSearch';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, ProjectSearch::class, 'id'],
            ];

        final public function __construct(array $where, int $limit) {
            $this->fillCollection(self::getDb()->select($where, ProjectSearch::getPropertyKeys(), null, $limit));
        }
    }
}
