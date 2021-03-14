<?php

namespace App\Models\Collection;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Models\Table\Language;
use App\Traits\IteratorTrait;
use App\Traits\Model;

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

    public function __construct(array $data) {
        $this->fillCollection($data);
    }
}
