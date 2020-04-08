<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\Table\User;
use Traits\IteratorTrait;
use Traits\Model;

/**
 * @var User[] $this
 */
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
