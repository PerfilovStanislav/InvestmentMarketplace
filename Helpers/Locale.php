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
        private static $availableLanguages = ['en', 'ru'];
        private static $language = null;
        private static $locale = null;

        public static final function getLanguage() {
            if (self::$language !== null) return self::$language;

            // 1: from profile
            $lang = Auth::getUserInfo()['lang'];
            if (in_array($lang, self::$availableLanguages)) return (self::$language = ucfirst($lang));

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
            if (!empty($langs)) return (self::$language = ucfirst($langs[0]));

            // 3: Default
            return (self::$language = self::$defaultLanguage);

            // #TODO
            // 4: language from ip .. Example module: TabgeoCountry
        }

        public static final function getLocale() {
            if (self::$locale !== null) return self::$locale;

            $locale = '\Helpers\Locales\\'.self::getLanguage();
            return (self::$locale = $locale::getLocale());
        }

        /*public static final function getErrors() {
            return ['errors' => self::$errors];
        }*/

    }

    
}