<?php

namespace App\Traits;

trait MView
{
    use Model;

    public static function refresh() {
        self::setTable()->refresh();
    }
}