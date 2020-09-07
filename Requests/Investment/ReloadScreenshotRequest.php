<?php

namespace Requests\Investment;

use Requests\AbstractRequest;
use Helpers\Validator;
use Models\Table\Project;

/**
 * @property int    $project
 */
class ReloadScreenshotRequest extends AbstractRequest {

    protected static array
        $properties = [
            'project'   => [self::TYPE_INT,        [Validator::MODEL => Project::class]],
        ];
}