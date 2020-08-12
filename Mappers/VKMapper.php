<?php

namespace Mappers;

use Models\Constant\Language;

class VKMapper
{
    public static function getCollection(): array
    {
        return [
            Language::EN => \Config::VK_GROUP_EN,
            Language::RU => \Config::VK_GROUP_RU,
            Language::ZH => \Config::VK_GROUP_ZH,
            Language::BN => \Config::VK_GROUP_BN,
            Language::ES => \Config::VK_GROUP_ES,
        ];
    }

    public static function getGroupId(int $lang): int {
        return self::getCollection()[$lang] ?? 0;
    }
}