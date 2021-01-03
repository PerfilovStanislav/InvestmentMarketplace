<?php

namespace App\Helpers\Data;

class Currency {
    public static function getCurrency(): array {
        $c = Translate()->currency;
        return [
            [],
            ['i' => '&#xf155;', 't' => $c[0]],
            ['i' => '&#xf153;', 't' => $c[1]],
            ['i' => '&#xf15a;', 't' => $c[2]],
            ['i' => '&#xf158;', 't' => $c[3]],
            ['i' => '&#xf154;', 't' => $c[4]],
            ['i' => '&#xf157;', 't' => $c[5]],
            ['i' => '&#xf159;', 't' => $c[6]],
            ['i' => '&#xf156;', 't' => $c[7]],
        ];
    }
}