<?php

namespace App\Requests\Telegram\Dto;

use App\Core\AbstractEntity;

/**
 * @var KeyboardRow[] $this
 */
class InlineKeyboard extends AbstractEntity {

    protected static array
        $properties = [
            self::COLLECTION => [self::TYPE_DTO_ARRAY, KeyboardRow::class],
        ];
}