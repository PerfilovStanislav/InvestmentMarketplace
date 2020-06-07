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
        ];
    }

    public static function getGroupId(int $lang): int {
        return self::getCollection()[$lang] ?? 0;
    }
}