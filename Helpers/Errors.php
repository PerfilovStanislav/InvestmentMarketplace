<?php
/**
 * Created by PhpStorm.
 * User: Beautynight
 * Date: 08.07.2016
 * Time: 21:25
 */

namespace Helpers {

    class Errors {
        private static $errors = [];

        public static final function setField($field, $key) {
            self::$errors['fields'][$field] = Locale::getLocale()[$key];
        }

        public static final function getErrors() {
            return ['error' => self::$errors];
        }

    }
}