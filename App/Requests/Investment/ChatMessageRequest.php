<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;

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