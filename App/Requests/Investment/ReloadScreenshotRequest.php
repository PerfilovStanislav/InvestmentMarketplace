<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Models\Table\Project;

/**
 * @property int    $project
 */
class ReloadScreenshotRequest extends AbstractRequest {

    protected static array
        $properties = [
            'project'   => [self::TYPE_INT,        [Validator::MODEL => 'project']],
        ];
}