<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\MView\MVProjectLang;
use Traits\MView;

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
        $this->fillCollection(static::getDb()->select($where, MVProjectLang::getPropertyKeys()));
    }
}
