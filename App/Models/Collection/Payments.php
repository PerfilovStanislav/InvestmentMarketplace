<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\Table\Payment;
use App\Traits\IteratorTrait;
use App\Traits\Model;

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
        $this->fillCollection(self::setTable()->select($where, Payment::getPropertyKeys(), 'pos asc'));
    }
}
