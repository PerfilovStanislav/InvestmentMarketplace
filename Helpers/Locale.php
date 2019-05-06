<?php

namespace Helpers {
    use \Core\Auth;
    use Core\Database;
	use Helpers\Locales\En;
	use Helpers\Locales\Ru;
    use Libraries\TabgeoCountry;

    class Locale {
        private static $defaultLanguage = 'en';
        private static $availableLanguages = null;
        private static $language = null;
        private static $locale = null;
        private static $localeFile = null;

        final public static function getLanguage() : string {
            if (self::$language !== null) return self::$language;
            // 1: from profile
            if ($lang = (Auth::getUserInfo()['lang'] ?? false)) return (self::$language = $lang);

            // 2: from session
            if ($lang = ($_SESSION['lang'] ?? false)) return (self::$language = $lang);

            // 3: from browser
            if ($list=($_SERVER['HTTP_ACCEPT_LANGUAGE']??false)) {
                $list = strtolower($list);
                if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                    $langs = array_combine($list[1], $list[2]);
                    foreach ($langs as $k => &$v)
                        $v = $v ? (float)$v : 1;
                    arsort($langs, SORT_NUMERIC);
                }
            }
            $langs = array_values(array_intersect(array_keys($langs ?? []), array_column(self::getAvailableLanguages(), 'shortname')));
            if (!empty($langs)) return (self::$language = $langs[0]);

            // 4: TabgeoCountry
            $country = strtolower(TabgeoCountry::getCountry());
            $lang = self::getLangByFlag($country);
            if ($lang) return (self::$language = $lang);

            // 5: Default
            return ($_SESSION['lang'] = self::$language = self::$defaultLanguage);
        }

        final public static function getLocale():array {
            return self::$locale?:(self::$locale = self::getLocaleFile()::getLocale());
        }

		/**
		 * @return En|Ru
		 */
        final public static function getLocaleFile():string {
            return self::$localeFile?:(self::$localeFile = '\Helpers\Locales\\'.ucfirst(self::getLanguage()));
        }

        final public static function getPeriodName($i,$k) {
            return self::getLocaleFile()::getPeriodName($i,$k);
        }

		final public static function getAvailableLanguages() {
			return self::$availableLanguages?:(self::$availableLanguages = array_column(
				Database::getInstance()->select('languages', 'id,name,own_name,flag,shortname', ['available' => 1])
				, null, 'shortname'
			));
		}

		final public static function get(string $key) {
			return self::getLocale()[$key];
		}

		/** @return int|null */
		final public static function getLangByName(string $shortname) {
			return Database::getInstance()->getRow('languages', 'id,shortname,flag', ['shortname' => $shortname]);
		}

		final private static function getLangByFlag(string $flag) {
            return Database::getInstance()->getOne('languages', ['flag' => $flag, 'available' => 1], 'shortname');
		}
    }
}