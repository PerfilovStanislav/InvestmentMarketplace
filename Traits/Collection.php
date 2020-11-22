<?php

namespace Traits;

trait Collection
{
    public static function getCollection() {
        static $cache;
        return $cache ??= self::getReflectionClass()->getConstants();
    }

    public static function getConstNames() {
        return array_keys(self::getCollection());
    }

    public static function getValue(string $key) {
        return self::getReflectionClass()->getConstant(mb_strtoupper($key));
    }

    public static function getValues() {
        return array_values(self::getCollection());
    }

    public static function getConstNameLower($val) {
        foreach (self::getCollection() as $name => $value) {
            if ($value == $val) return mb_strtolower($name);
        }
    }

    private static function getReflectionClass() {
        static $cache;
        return $cache ??= new \ReflectionClass(__CLASS__);
    }
}
