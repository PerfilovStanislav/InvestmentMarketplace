<?php
/**
 * Created by PhpStorm.
 * User: Beautynight
 * Date: 08.07.2016
 * Time: 21:25
 */

namespace Helpers {
    use \Core\Auth;
    use Core\Database;

    class Locale {
        private static $defaultLanguage = 'en';
        private static $availableLanguages = null;
        private static $language = null;
        private static $locale = null;
        private static $localeFile = null;

        public static final function getLanguage() {
            if (self::$language !== null) return self::$language;
            // 1: from profile
            if ($lang = (Auth::getUserInfo()['lang'] ?? false)) return (self::$language = ucfirst($lang));

            // 2: from session
            if ($_SESSION['lang'] ?? false) return (self::$language = $_SESSION['lang']);

            // 3: from browser
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
                if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                    $langs = array_combine($list[1], $list[2]);
                    foreach ($langs as $k => &$v)
                        $v = $v ? (float)$v : 1;
                    arsort($langs, SORT_NUMERIC);
                }
            }
            $langs = array_values(array_intersect(array_keys($langs ?? ''), (new Arrays(self::getAvailableLanguages()))->arrayColumn('shortname')->getArray()));
            if (!empty($langs)) return (self::$language = $langs[0]);

            // #TODO
            // 4: language from ip .. Example module: TabgeoCountry

            // 5: Default

            return ($_SESSION['lang'] = self::$language = self::$defaultLanguage);
        }

        public static final function getLocale() {
            return self::$locale?:(self::$locale = self::getLocaleFile()::getLocale());
        }

        public static final function getLocaleFile() {
            return self::$localeFile?:(self::$localeFile = '\Helpers\Locales\\'.ucfirst(self::getLanguage()));
        }

        public static final function getPeriodName($i,$k) {
            return self::getLocaleFile()::getPeriodName($i,$k);
        }

        public static final function getAvailableLanguages() {
            return self::$availableLanguages?:(self::$availableLanguages = Database::getInstance()->select('languages', 'shortname', 'available = true'));
        }

    }

    
}