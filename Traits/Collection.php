<?php

namespace Traits;

trait Collection
{
    final public static function getCollection() : array {
       return (new \ReflectionClass(__CLASS__))->getConstants();
    }

    final public static function getValue(string $key) : ?int {
        return (new \ReflectionClass(__CLASS__))->getConstant(mb_strtoupper($key)) ?? null;
    }

    final public static function getConstName(int $key) : string {
        foreach (self::getCollection() as $name => $value) {
            if ($value == $key) return mb_strtolower($name);
        }
    }
}
