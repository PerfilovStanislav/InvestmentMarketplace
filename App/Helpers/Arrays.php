<?php

namespace App\Helpers;

class Arrays {
    public static function groupBy(array $array, array $cols): array {
        $newArray = [];
        foreach ($array as $a) {
            $t = &$newArray;
            foreach ($cols as $col) {
                $t = &$t[$a[$col]];
            }
            $t = array_filter($a, function($k) use($cols): bool {
                    return !in_array($k, $cols);
                },ARRAY_FILTER_USE_KEY);
        }
        return $newArray;
    }

    public static function toUri(array $params): string {
        $array = [];
        foreach ($params as $key => $value) {
            $array[] = "$key/$value";
        }
        return implode('/', $array);
    }
}
