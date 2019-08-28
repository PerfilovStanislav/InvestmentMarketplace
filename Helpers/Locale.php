<?php

namespace Helpers {
	use Helpers\Locales\En;
	use Helpers\Locales\Ru;
    use Libraries\TabgeoCountry;
    use Models\AuthModel;
    use Models\Collection\MVSiteAvailableLanguages;
    use Models\Table\Language;

    class Locale {
        private static $defaultLanguage = 'en';
        private static $language = null;
        private static $locale = null;
        private static $localeFile = null;

        public static function getLanguage() : string {
            if (self::$language !== null) return self::$language;
            // 1: from profile
            if ($user = (AuthModel::getInstance()->user)) {
                /** @var Language $language */
                $language = MVSiteAvailableLanguages::getInstance()->getByKeyAndValue('id', $user->lang_id);
                return (self::$language = $language->shortname);
            }

            // 2: from session
            if ($lang = ($_SESSION['lang'] ?? false)) return (self::$language = $lang);

            // 3: from browser
            if ($list=($_SERVER['HTTP_ACCEPT_LANGUAGE']??false)) {
                $list = strtolower($list);
                if (preg_match_all('/,?([a-z]{2}).*?[,;]?q=([0-9.]*)/', $list, $list)) {
                    $langs = array_combine($list[1], $list[2]);
                    foreach ($langs as $k => &$v) {
                        $v = $v ? (float)$v : 1;
                    }
                    arsort($langs, SORT_NUMERIC);
                }
            }
            foreach (array_keys($langs ?? []) as $langName) {
                if (MVSiteAvailableLanguages::getInstance()->$langName) {
                    return (self::$language = $_SESSION['lang'] = $langName);
                }
            }

            // 4: TabgeoCountry
            $flag = strtolower(TabgeoCountry::getCountry());
            /** @var Language $language */
            $language = MVSiteAvailableLanguages::getInstance()->getByKeyAndValue('flag', $flag);
            if ($language) return (self::$language = $_SESSION['lang'] = $language->shortname);

            // 5: Default
            return ($_SESSION['lang'] = self::$language = self::$defaultLanguage);
        }

        public static function getLocale():array {
            return self::$locale ?: (self::$locale = self::getLocaleFile()::getLocale());
        }

		/**
		 * @return En|Ru
		 */
        public static function getLocaleFile():string {
            return self::$localeFile?:(self::$localeFile = '\Helpers\Locales\\'.ucfirst(self::getLanguage()));
        }

        public static function getPeriodName($i,$k) {
            return self::getLocaleFile()::getPeriodName($i,$k);
        }

		public static function get(string $key) {
			return self::getLocale()[$key];
		}
    }
}
