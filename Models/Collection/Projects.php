<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\Table\Project;
use Traits\IteratorTrait;
use Traits\Model;

/**
 * @var Project[] $this
 */
class Projects extends AbstractEntity implements ModelInterface, \Iterator {
    use Model;
    use IteratorTrait;

    private static string $table = 'project';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, Project::class, 'id'],
        ];

    public function __construct(array $where) {
        $this->fillCollection(self::getDb()->select($where, Project::getPropertyKeys(), 'id desc'));
    }
}
