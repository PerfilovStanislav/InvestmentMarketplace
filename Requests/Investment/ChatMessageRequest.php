<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;

/**
 * @property int $id
 * @property int $project_id
 */
class ChatMessageRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties = [
            'id'         => [self::TYPE_INT, [Validator::MIN => 0]],
            'project_id' => [self::TYPE_INT, [Validator::MIN => 1]],
        ];
}