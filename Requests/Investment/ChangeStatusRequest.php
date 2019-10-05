<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Constant\ProjectStatus;
use Models\Table\Project;

/**
 * @property int    $project
 * @property string $status
 */
class ChangeStatusRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties = [
            'status'    => [self::TYPE_CONSTANTS,  ProjectStatus::class],
            'project'   => [self::TYPE_INT,    [Validator::MODEL => Project::class]],
        ];
}