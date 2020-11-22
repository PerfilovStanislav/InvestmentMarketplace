<?php

namespace Traits;

trait Instance {
    private static ?self $_instance = null;

    public static function getInstance() {
        return static::$_instance ??= new static();
    }

    protected function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
