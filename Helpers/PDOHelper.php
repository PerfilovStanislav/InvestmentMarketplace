<?php

namespace Helpers;

class PDOHelper {

    private static array $preparedValues = [];
    private static int $preparedCount = 0;

    public static function prepareVal($key, $value): string {
        if (!isset(self::$preparedValues[$key][$value])) {
            self::$preparedValues[$key][$value] = ++self::$preparedCount;
        }
        return $key . '_' . self::$preparedValues[$key][$value];
    }
}
