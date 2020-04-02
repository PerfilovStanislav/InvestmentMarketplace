<?php

namespace Helpers\Locales;

class LanguageCollection
{
    public CONST
        EN = 'en',
        RU = 'ru',
        ZH = 'zh';

    public CONST LANGUAGES = [
        self::EN => En::class,
        self::RU => Ru::class,
        self::ZH => Zh::class,
    ];

    public static function get(string $language): AbstractLanguage {
        $languageClass = self::LANGUAGES[$language];
        return new $languageClass();
    }
}
