<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Table\Project;

/**
 * @property integer    $project
 */
class RedirectRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties = [
            'project' => [self::TYPE_INT, [Validator::MODEL => Project::class]],
        ];
}
