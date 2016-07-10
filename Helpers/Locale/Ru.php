<?php
/**
 * Created by PhpStorm.
 * User: Beautynight
 * Date: 08.07.2016
 * Time: 22:49
 */

namespace Helpers\Locale {

    class Ru {
        private static $locale = [
            'login_is_busy' => 'Данный логин уже зарегистрирован. Введите другой',
            'email_is_busy' => 'Данный email уже зарегистрирован. Введите другой'
        ];

        public static function getLocale() {
            return self::$locale;
        }
    }
}