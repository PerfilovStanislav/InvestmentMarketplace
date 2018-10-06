<?php

namespace Helpers {

    class Errors {
        private static $errors = [];

        public static final function setField($field, $key) {
            self::$errors['fields'][$field] = Locale::getLocale()[$key];
        }

        public static final function getErrors(string $scope = 'document'):array {
            return ['error' => [$scope => self::$errors]];
        }
	}
}