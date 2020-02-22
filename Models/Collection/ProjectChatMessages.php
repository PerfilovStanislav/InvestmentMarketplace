<?php

namespace Models\Collection;

use Core\AbstractEntity;
use Core\Database;
use Interfaces\EntityInterface;
use Models\Table\ProjectChatMessage;
use Requests\Investment\ChatMessageRequest;
use Requests\Investment\ChatMessagesRequest;
use Traits\IteratorTrait;

/**
 * @var ProjectChatMessage[] $this
 */
class ProjectChatMessages extends AbstractEntity implements EntityInterface, \Iterator, \Countable {
    use IteratorTrait;

    protected static array
        $properties = [
            self::COLLECTION  => [self::TYPE_DTO_ARRAY, ProjectChatMessage::class, 'id'],
        ];

    public function __construct(ChatMessagesRequest $request) {
        $sql = implode(' UNION ALL ', array_map(static function(ChatMessageRequest $param) use ($request) {
                return "
                    (SELECT id, date_create, user_id, project_id, message, session_id
                    FROM message
                    WHERE project_id = {$param->project_id} and id>{$param->id} and lang_id = {$request->lang}
                    ORDER BY id desc
                    limit 50)
                ";
            }, $request->messages
        ));
        $this->fillCollection(Database::getInstance()->rawSelect($sql));
    }
}
