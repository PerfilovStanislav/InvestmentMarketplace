<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\Table\Redirect;
use App\Traits\Model;

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
