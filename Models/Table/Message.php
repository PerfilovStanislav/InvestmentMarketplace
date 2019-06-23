<?php

namespace Models\Table {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;

    /**
     * @property int    $id
     * @property string $date_create
     * @property int    $user_id
     * @property int    $project_id
     * @property int    $lang_id
     * @property string $message
     * @property int    $session_id
     */
    class Message extends AbstractEntity implements EntityInterface {

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'          => [self::TYPE_INT,      [Validator::MIN => 1]],
                'date_create' => [self::TYPE_DATETIME, []],
                'user_id'     => [self::TYPE_INT,      []],
                'project_id'  => [self::TYPE_INT,      []],
                'lang_id'     => [self::TYPE_INT,      [Validator::MIN => 1]],
                'message'     => [self::TYPE_STRING,   [Validator::MIN => 1]],
                'session_id'  => [self::TYPE_INT,      [Validator::MIN => 1]],
            ];
    }
}
