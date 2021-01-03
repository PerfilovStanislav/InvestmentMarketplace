<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\Table\ProjectLang;
use App\Traits\IteratorTrait;
use App\Traits\Model;

/**
 * @var ProjectLang[] $this
 */
class ProjectLangs extends AbstractEntity implements ModelInterface, \Iterator, \Countable {
    use Model;
    use IteratorTrait;

    private static string $table = 'project_lang';

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, ProjectLang::class, 'id'],
        ];

    public function __construct(array $where = []) {
        $this->fillCollection(self::setTable()->select($where, ProjectLang::getPropertyKeys()));
    }
}
