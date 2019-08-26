<?php

namespace Helpers {

    class Errors
    {
        private static $errors = [];

        public static function add($key, string $description, bool $showAndExit = false) {
            self::$errors[$key] = $description;
            if ($showAndExit) {
                self::showIfExists();
            }
        }

        public static function get() {
            return self::$errors;
        }

        public static function showIfExists() {
            if (self::get()) {
                foreach (self::get() as $key => $description) {
                    Output::addFieldDanger($key, $description, Output::DOCUMENT);
                }
//                return Output::result();
            }
        }
    }
}
