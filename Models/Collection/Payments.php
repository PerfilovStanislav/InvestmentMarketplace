<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\Table\Payment;
use Traits\IteratorTrait;
use Traits\Model;

/**
 * @var Payment[] $this
 */
class Payments extends AbstractEntity implements ModelInterface, \Iterator, \Countable {
    use Model;
    use IteratorTrait;

    private static string $table = 'payments';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, Payment::class, 'id'],
        ];

    public function __construct(array $where = []) {
        $this->fillCollection(self::getDb()->select($where, Payment::getPropertyKeys(), 'pos asc'));
    }
}
