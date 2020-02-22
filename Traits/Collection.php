<?php

namespace Traits;

trait Collection
{
    public static function getCollection(): array {
        static $cache;
        if ($cache) return $cache;
        return ($cache = self::getReflectionClass()->getConstants());
    }

    public static function getConstNames(): array {
        return array_keys(self::getCollection());
    }

    public static function getValue(string $key) {
        return self::getReflectionClass()->getConstant(mb_strtoupper($key)) ?? null;
    }

    public static function getValues(): array {
        return array_values(self::getCollection());
    }

    public static function getConstName($key): string {
        foreach (self::getCollection() as $name => $value) {
            if ($value == $key) return mb_strtolower($name);
        }
    }

    private static function getReflectionClass() : \ReflectionClass {
        static $cache;
        if ($cache) return $cache;
        return ($cache = new \ReflectionClass(__CLASS__));

    }
}
