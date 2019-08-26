<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\Table\ProjectLang;
    use Traits\Model;

    /**
     * @var ProjectLang[] $this
     */
    class ProjectLangs extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'project_lang';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, ProjectLang::class, 'id'],
            ];

        public function __construct(array $where = []) {
            $this->fillCollection(self::getDb()->select($where, ProjectLang::getPropertyKeys()));
        }
    }
}
