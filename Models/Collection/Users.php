<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\Table\User;
    use Traits\IteratorTrait;
    use Traits\Model;

    /**
     * @var User[] $this
     */
    class Users extends AbstractEntity implements EntityInterface, ModelInterface, \Iterator {
        use Model;
        use IteratorTrait;

        private static $table = 'users';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, User::class, 'id'],
            ];

        public function __construct(array $where, array $fields = []) {
            $this->fillCollection(self::getDb()->select($where, $fields ?? User::getPropertyKeys()));
        }
    }
}
