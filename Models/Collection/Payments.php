<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\Table\Payment;
    use Traits\Model;

    /**
     * @var Payment[] $this
     */
    class Payments extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'payments';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, Payment::class, 'id'],
            ];

        final public function __construct(array $where) {
            $this->fillCollection(self::getDb()->select($where, Payment::getPropertyKeys()));
        }
    }
}
