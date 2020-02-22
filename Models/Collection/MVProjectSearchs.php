<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\MView\MVProjectSearch;
use Traits\IteratorTrait;
use Traits\MView;

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
        $this->fillCollection(static::getDb()->select($where, MVProjectSearch::getPropertyKeys(), null, $limit));
    }
}
