<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\Table\Language;
use Traits\IteratorTrait;
use Traits\Model;

/**
 * @var Language[] $this
 */
class Languages extends AbstractEntity implements ModelInterface, \Iterator, \Countable {
    use Model;
    use IteratorTrait;

    private static string $table = 'languages';

    protected static array
        $properties = [
            self::COLLECTION => [self::TYPE_DTO_ARRAY, Language::class, 'id'],
        ];

    public function __construct($where = [], string $order = null) {
        $this->fillCollection(self::getDb()->select($where, Language::getPropertyKeys(), $order));
    }
}
