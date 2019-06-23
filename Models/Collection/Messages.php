<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\Table\Message;
    use Traits\Model;

    /**
     * @var Message[] $this
     */
    class Messages extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'message';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, Message::class, 'id'],
            ];

        final public function __construct(array $where) {
            $this->fillCollection(self::getDb()->select($where, Message::getPropertyKeys()));
        }
    }
}
