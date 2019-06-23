<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\Table\Language;
    use Traits\Model;

    /**
     * @var Language[] $this
     */
    class Languages extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'languages';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, Language::class, 'id'],
            ];

        final public function __construct(array $where) {
            $this->fillCollection(self::getDb()->select($where, Language::getPropertyKeys()));
        }
    }
}
