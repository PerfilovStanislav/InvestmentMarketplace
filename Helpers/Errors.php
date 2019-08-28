<?php

namespace Helpers {

    class Errors
    {
        private static $hasError = false;

        public static function add($key, string $description, bool $exit = false) {
            self::$hasError = true;
            Output::addFieldDanger($key, $description);
            if ($exit) {
                return Output::result();
            }
        }

        public static function exitIfExists() {
            if (self::$hasError) {
                return Output::result();
            }
        }
    }
}
