<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\MView\MVProjectCount;
use App\Traits\IteratorTrait;
use App\Traits\MView;

/**
 * @var MVProjectCount[] $this
 */
class MVProjectCounts extends AbstractEntity implements ModelInterface, \Iterator, \Countable {
    use MView;
    use IteratorTrait;

    private static string $table = 'mv_project_count';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, MVProjectCount::class, 'status_id'],
        ];

    public function __construct(array $where = [], int $limit = null) {
        $this->fillCollection(static::setTable()->select($where, MVProjectCount::getPropertyKeys(), null, $limit));
    }
}
