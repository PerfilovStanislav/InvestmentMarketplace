<?php
/**
 * Created by PhpStorm.
 * User: Beautynight
 * Date: 08.07.2016
 * Time: 21:25
 */

namespace Helpers {
    use \Core\Auth;

    class Locale {
        private static $defaultLanguage = 'Ru';
        private static $locale;

        private static final function getLocale() {
            $lang = Auth::getUserInfo()['lang'];
            print_r(['rrr' => Auth::getUserInfo()]); die();
            $lang = 'Ru';
            $locale = "\\Helpers\\Locale\\{$lang}::getLocale";
            self::$locale = call_user_func($locale);
            return self::$locale;
        }

        public static final function getErrors() {
            return ['errors' => self::$errors];
        }

    }

    
}