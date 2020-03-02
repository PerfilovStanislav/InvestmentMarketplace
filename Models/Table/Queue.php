<?php

namespace Models\Table;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\ModelInterface;
use Traits\Model;

/**
 * @property int       $id
 * @property int       $action_id
 * @property int       $status_id
 * @property array     $payload
 * @property \datetime $start_time
 * @property \datetime $end_time
 */
class Queue extends AbstractEntity implements ModelInterface {

    public const ACTION_ID_SCREENSHOT = 1;

    public const
        STATUS_CREATED  = 1,
        STATUS_STARTED  = 2,
        STATUS_FINISHED = 3;

    use Model;

    private static string $table = 'Queue';

    protected static array
        $properties = [
            'id'         => [self::TYPE_INT,      [Validator::MIN  => 1]],
            'action_id'  => [self::TYPE_INT,      [Validator::MIN  => 1]],
            'status_id'  => [self::TYPE_INT,      [Validator::MIN  => 1]],
            'payload'    => [self::TYPE_JSON,     []],
            'start_time' => [self::TYPE_DATETIME, []],
            'end_time'   => [self::TYPE_DATETIME, []],
        ];
}
