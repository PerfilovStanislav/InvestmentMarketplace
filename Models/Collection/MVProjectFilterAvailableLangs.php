<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\MView\MVProjectFilterAvailableLang;
use Traits\IteratorTrait;
use Traits\MView;

/**
 * @property MVProjectFilterAvailableLang[] $this
 */
class MVProjectFilterAvailableLangs extends AbstractEntity implements ModelInterface, \Iterator, \Countable {
    use MView;
    use IteratorTrait;

    private static string $table = 'MV_ProjectFilterAvailableLangs';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, MVProjectFilterAvailableLang::class, 'lang_id'],
        ];

    public function __construct(array $where) {
        $this->fillCollection(static::setTable()->select($where, MVProjectFilterAvailableLang::getPropertyKeys(), 'cnt desc'));
    }
}
