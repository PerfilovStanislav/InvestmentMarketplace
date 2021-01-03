<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\Table\Project;
use App\Traits\IteratorTrait;
use App\Traits\Model;

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
        $this->fillCollection(self::setTable()->select($where, Project::getPropertyKeys(), 'id desc'));
    }
}
