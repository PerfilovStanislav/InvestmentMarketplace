<?php

namespace Mappers;

use Models\Constant\Language;

class FacebookMapper
{
    public static function getCollection(): array
    {
        return [
            Language::EN => \Config::FB_PAGE_EN_ID,
            Language::RU => \Config::FB_PAGE_RU_ID,
            Language::ZH => \Config::FB_PAGE_ZH_ID,
            Language::HI => \Config::FB_PAGE_HI_ID,
        ];
    }

    public static function getPageId(int $lang): int {
        return self::getCollection()[$lang] ?? 0;
    }

    public static function getPageToken(int $pageId): string {
        return [
            \Config::FB_PAGE_EN_ID => \Config::FB_PAGE_EN_TOKEN,
            \Config::FB_PAGE_RU_ID => \Config::FB_PAGE_RU_TOKEN,
            \Config::FB_PAGE_ZH_ID => \Config::FB_PAGE_ZH_TOKEN,
            \Config::FB_PAGE_HI_ID => \Config::FB_PAGE_HI_TOKEN,
        ][$pageId] ?? '';
    }
}