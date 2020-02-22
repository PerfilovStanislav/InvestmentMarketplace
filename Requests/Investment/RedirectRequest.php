<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Validator;
use Models\Table\Project;

/**
 * @property integer    $project
 */
class RedirectRequest extends AbstractEntity {

    protected static array
        $properties = [
            'project' => [self::TYPE_INT, [Validator::MODEL => Project::class]],
        ];
}
