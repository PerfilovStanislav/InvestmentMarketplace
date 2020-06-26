<?php

namespace Helpers;

use Helpers\Locales\AbstractLanguage;
use Helpers\Locales\SiteLanguageCollection;
use Libraries\TabgeoCountry;
use Models\Table\Language;
use Traits\Instance;

class Locale {
    use Instance;

    private string  $defaultLanguage = 'en';
    private ?string $language        = null;
    private AbstractLanguage $locale;

    public function setLanguage(string $lang): void {
        $this->language = $lang;
    }

    public function getLanguage(): string {
        if ($this->language !== null) {
            return $this->language;
        }

        // 1: from profile
        if ($user = (CurrentUser()->user)) {
            /** @var Language $language */
            $language = App()->siteLanguages()->getByKeyAndValue('id', $user->lang_id);
            return ($this->language = $language->shortname);
        }

        // 2: from session
        if ($lang = ($_SESSION['lang'] ?? null)) {
            return ($this->language = $lang);
        }

        // 3: from browser
        if ($list=($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null)) {
            $list = strtolower($list);
            if (preg_match_all('/,?([a-z]{2}).*?[,;]?q=([0-9.]*)/', $list, $list)) {
                $langs = array_combine($list[1], $list[2]);
                foreach ($langs as $k => &$v) {
                    $v = $v ? (float)$v : 1;
                }
                unset($v);
                arsort($langs, SORT_NUMERIC);
            }
        }
        foreach (array_keys($langs ?? []) as $langName) {
            if (App()->siteLanguages()->$langName) {
                return ($this->language = $_SESSION['lang'] = $langName);
            }
            sendToTelegram(['language' => $langName, 'line' => __LINE__]);
        }

        // 4: TabgeoCountry
        $flag = strtolower(TabgeoCountry::getCountry());
        /** @var Language $language */
        $language = App()->siteLanguages()->getByKeyAndValue('flag', $flag);
        if ($language) {
            return ($this->language = $_SESSION['lang'] = $language->shortname);
        }

        // 5: Default
        return ($_SESSION['lang'] = $this->language = $this->defaultLanguage);
    }

    public function translate(): AbstractLanguage {
        return $this->locale ??= SiteLanguageCollection::getByShortname($this->getLanguage());
    }
}
