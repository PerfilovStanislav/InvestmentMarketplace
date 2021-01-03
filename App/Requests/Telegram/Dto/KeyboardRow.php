<?php

namespace App\Requests\Telegram\Dto;

use App\Core\AbstractEntity;

/**
 * @var KeyboardButton[] $this
 */
class KeyboardRow extends AbstractEntity {

    protected static array
        $properties = [
            self::COLLECTION => [self::TYPE_DTO_ARRAY, KeyboardButton::class, 'text'],
        ];

    public function __construct(array $data = [])
    {
        $this->fillCollection($data);
    }
}