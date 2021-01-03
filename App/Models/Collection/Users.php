<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\Table\User;
use App\Traits\IteratorTrait;
use App\Traits\Model;

class Users extends AbstractEntity implements ModelInterface, \Iterator {
    use Model;
    use IteratorTrait;

    private static string $table = 'users';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, User::class, 'id'],
        ];

    public function __construct(array $where, array $fields = []) {
        $this->fillCollection(self::setTable()->select($where, $fields ?? User::getPropertyKeys()));
    }
}
