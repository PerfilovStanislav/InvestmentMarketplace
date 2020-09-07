<?php

namespace Requests\Investment;

use Requests\AbstractRequest;
use Helpers\Validator;

/**
 * @property int $id
 * @property int $project_id
 */
class ChatMessageRequest extends AbstractRequest {

    protected static array
        $properties = [
            'id'         => [self::TYPE_INT, [Validator::MIN => 0]],
            'project_id' => [self::TYPE_INT, [Validator::MIN => 1]],
        ];
}