<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Models\Table\Language;
use App\Models\Table\Project;

/**
 * @property int    $lang
 * @property int    $project
 * @property string $message
 */
class SetChatMessageRequest extends AbstractRequest {

    protected static array
        $properties = [
            'lang'    => [self::TYPE_INT,    [Validator::MODEL => Language::class]],
            'project' => [self::TYPE_INT,    [Validator::MODEL => Project::class]],
            'message' => [self::TYPE_STRING, [Validator::MIN => 1, Validator::MAX => 2047, ]],
        ];
}
