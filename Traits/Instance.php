<?php

namespace Traits;

trait Instance
{
    final public static function getInstance() {
        return static::$_instance?:(static::$_instance = new static());
    }
}