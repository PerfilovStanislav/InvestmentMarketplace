<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\Table\Redirect;
use Traits\Model;

/**
 * @var Redirect[] $this
 */
class Redirects extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'redirect';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, Redirect::class, 'id'],
        ];

    public function __construct(array $where) {
        $this->fillCollection(self::setTable()->select($where, Redirect::getPropertyKeys()));
    }
}
