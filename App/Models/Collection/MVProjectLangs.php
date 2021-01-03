<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\MView\MVProjectLang;
use App\Traits\MView;

/**
 * @var MVProjectLang[] $this
 */
class MVProjectLangs extends AbstractEntity implements ModelInterface {
    use MView;

    private static string $table = 'mv_projectlangs';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, MVProjectLang::class, 'id'],
        ];

    public function __construct(array $where) {
        $this->fillCollection(static::setTable()->select($where, MVProjectLang::getPropertyKeys()));
    }
}
