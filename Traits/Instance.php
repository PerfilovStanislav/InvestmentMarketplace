<?php

namespace Traits;

trait Instance {
    private static $_instance = null;

    public static function getInstance() {
        return static::$_instance ?: (static::$_instance = new static());
    }
}
