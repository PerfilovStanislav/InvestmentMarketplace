<?php
/**
 * Created by PhpStorm.
 * User: Beautynight
 * Date: 08.07.2016
 * Time: 21:25
 */

namespace Helpers {
    use \Core\Auth;
    use \Libraries\TabgeoCountry;

    class Locale {
        private static $defaultLanguage = 'ru';
        private static $availableLanguages = ['en', 'ru', 'de'];
        private static $language = null;
        private static $locale;

        private static final function getLanguage() {
            // 1: from profile
            $lang = Auth::getUserInfo()['lang'];
//            if (in_array($lang, self::$availableLanguages)) return $lang;

            // 2: from browser
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
                if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                    $langs = array_combine($list[1], $list[2]);
                    foreach ($langs as $k => &$v)
                        $v = $v ? (float)$v : 1;
                    arsort($langs, SORT_NUMERIC);
                }
            }
            $langs = array_values(array_intersect(array_keys($langs), self::$availableLanguages));
//            if (!empty($langs)) return $langs[0];
            
            // 3: from ip
            $lang = TabgeoCountry::getCountry();

            return 'Error!';
        }

        public static final function getLocale() {
            self::$language = self::getLanguage();
            print_r(self::$language); die();

            /*
            $lang = Auth::getUserInfo()['lang'];
            print_r(['rrr' => Auth::getUserInfo()]); die();
            $lang = 'Ru';
            $locale = "\\Helpers\\Locale\\{$lang}::getLocale";
            self::$locale = call_user_func($locale);
            */


            return self::$locale;
        }

        public static final function getErrors() {
            return ['errors' => self::$errors];
        }

    }

    
}