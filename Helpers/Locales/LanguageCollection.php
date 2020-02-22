<?php

namespace Helpers\Locales;

class LanguageCollection
{
    public CONST
        EN = 'en',
        RU = 'ru';

    public CONST LANGUAGES = [
            self::EN => En::class,
            self::RU => Ru::class,
        ];

    public static function get(string $language): AbstractLanguage {
        $languageClass = self::LANGUAGES[$language];
        return new $languageClass();
    }
}
