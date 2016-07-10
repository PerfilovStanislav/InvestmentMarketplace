<?php
namespace Config {

    class Locale {
    private static $XXX = 'rrr';

        public static final function Ttt() {
            echo self::$XXX;
        }


        public static function Yyy($rr) {
            self::$XXX = $rr;
        }
    }
}