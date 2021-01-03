<?php

namespace App\Requests;

use App\Core\AbstractEntity;

abstract class AbstractRequest extends AbstractEntity
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        foreach (static::$properties as $key => $property) {
            if (!isset($this->data[$key]) && ($property[2] ?? null) !== AbstractEntity::TYPE_NOT_REQUIRED) {
                Error()->add($key, Translate()->required);
            }
        }
        Error()->exitIfExists();
    }
}