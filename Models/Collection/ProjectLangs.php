<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Interfaces\ModelInterface;
use Models\Table\ProjectLang;
use Traits\IteratorTrait;
use Traits\Model;

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
