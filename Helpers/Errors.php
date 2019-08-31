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

        public static function hasError() : bool {
            return self::$hasError;
        }

        public static function exitIfExists(string $head = null) {
            if (self::hasError()) {
                if ($head) {
                    Output::header($head);
                }
                return Output::result();
            }
        }
    }
}
