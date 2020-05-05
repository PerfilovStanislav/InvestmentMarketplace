<?php

namespace Requests\Telegram\Dto;

use Core\AbstractEntity;

/**
 * @var KeyboardRow[] $this
 */
class InlineKeyboard extends AbstractEntity {

    protected static array
        $properties = [
            self::COLLECTION => [self::TYPE_DTO_ARRAY, KeyboardRow::class],
        ];
}