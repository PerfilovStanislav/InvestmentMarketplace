<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\MView\MVProjectSearch;
use App\Traits\IteratorTrait;
use App\Traits\MView;

/**
 * @var MVProjectSearch[] $this
 */
class MVProjectSearchs extends AbstractEntity implements ModelInterface, \Iterator, \Countable {
    use MView;
    use IteratorTrait;

    private static string $table = 'MV_ProjectSearchs';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, MVProjectSearch::class, 'id'],
        ];

    public function __construct(array $where, int $limit) {
        $this->fillCollection(static::setTable()->select($where, MVProjectSearch::getPropertyKeys(), null, $limit));
    }
}
