<?php

namespace App\Traits;

trait Instance {
    private static ?self $_instance = null;

    public static function inst() {
        return static::$_instance ??= new static();
    }

    protected function __construct() {}
    private function __clone() {}
    final public function __wakeup() {}
}
