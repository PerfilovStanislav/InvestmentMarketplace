<?php

namespace Requests\Investment;

use Requests\AbstractRequest;
use Helpers\Validator;
use Models\Table\Project;

/**
 * @property integer    $project
 */
class RedirectRequest extends AbstractRequest {

    protected static array
        $properties = [
            'project' => [self::TYPE_INT, [Validator::MODEL => Project::class]],
        ];
}
