<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Models\Constant\ProjectStatus;
use App\Models\Table\Project;

/**
 * @property int $project
 * @property int $status
 */
class ChangeStatusRequest extends AbstractRequest {

    protected static array
        $properties = [
            'status'    => [self::TYPE_CONSTANTS,  ProjectStatus::class],
            'project'   => [self::TYPE_INT,        [Validator::MODEL => Project::class]],
        ];
}