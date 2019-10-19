<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\EntityInterface;
    use Interfaces\ModelInterface;
    use Models\MView\MVProjectFilterAvailableLang;
    use Traits\IteratorTrait;
    use Traits\MView;

    /**
     * @property MVProjectFilterAvailableLang[] $this
     */
    class MVProjectFilterAvailableLangs extends AbstractEntity implements EntityInterface, ModelInterface, \Iterator, \Countable {
        use MView;
        use IteratorTrait;

        private static $table = 'MV_ProjectFilterAvailableLangs';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, MVProjectFilterAvailableLang::class, 'lang_id'],
            ];

        public function __construct(array $where) {
            $this->fillCollection(self::getDb()->select($where, MVProjectFilterAvailableLang::getPropertyKeys(), 'cnt desc'));
        }
    }
}
