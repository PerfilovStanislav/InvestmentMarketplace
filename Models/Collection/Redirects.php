<?php

namespace Models\Collection {

    use Core\AbstractEntity;
    use Interfaces\{
        EntityInterface,
        ModelInterface
    };
    use Models\Table\Redirect;
    use Traits\Model;

    /**
     * @var Redirect[] $this
     */
    class Redirects extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'redirect';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                self::COLLECTION  => [self::TYPE_DTO_ARRAY, Redirect::class, 'id'],
            ];

        final public function __construct(array $where) {
            $this->fillCollection(self::getDb()->select($where, Redirect::getPropertyKeys()));
        }
    }
}
