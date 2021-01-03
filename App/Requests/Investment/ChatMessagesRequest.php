<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Interfaces\ModelInterface;
use App\Traits\IteratorTrait;
use App\Traits\Model;

/**
 * @property ChatMessageRequest[] $messages
 * @property int $lang
 */
class ChatMessagesRequest extends AbstractRequest implements ModelInterface, \Iterator {
    use Model;
    use IteratorTrait;

    protected static array
        $properties = [
            'messages' => [self::TYPE_DTO_ARRAY, ChatMessageRequest::class, 'project_id'],
            'lang'     => [self::TYPE_INT, [Validator::MIN => 183, Validator::MAX => 364]],
        ];
}
