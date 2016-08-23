<?php
/**
 * Created by PhpStorm.
 * User: Beautynight
 * Date: 08.07.2016
 * Time: 21:25
 */

namespace Helpers {
    use \Core\Auth;
    use Helpers\Locale;

    class Errors {
        private static $errors = [];
        private static $locale;

        public static final function setField($field, $key) {
            self::$errors['fields'][$field] = Locale::getLocale()[$key];
        }

        public static final function getErrors() {
            return ['errors' => self::$errors];
        }

    }
}