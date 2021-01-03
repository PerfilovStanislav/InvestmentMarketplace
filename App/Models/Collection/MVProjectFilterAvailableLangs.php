<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\MView\MVProjectFilterAvailableLang;
use App\Traits\IteratorTrait;
use App\Traits\MView;

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
