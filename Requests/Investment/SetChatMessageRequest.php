<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Arrays;
use Helpers\Locale;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Constant\ProjectStatus;
use Models\Table\Language;
use Models\Table\Project;

/**
 * @property int    $lang
 * @property int    $project
 * @property string $message
 */
class SetChatMessageRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties = [
            'lang'    => [self::TYPE_INT,    [Validator::MODEL => Language::class]],
            'project' => [self::TYPE_INT,    [Validator::MODEL => Project::class]],
            'message' => [self::TYPE_STRING, [Validator::MIN => 1, Validator::MAX => 2047, ]],
        ];
}
