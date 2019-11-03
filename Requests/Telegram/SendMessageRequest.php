<?php

namespace Requests\Telegram;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Constant\TelegramParseMode;

/**
 * @property int    $chat_id
 * @property string $text
 * @property string $parse_mode
 */
class SendMessageRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = [
            'parse_mode' => TelegramParseMode::MARKDOWN,
        ],
        $properties = [
            'chat_id'     => [self::TYPE_INT,        [Validator::MIN => 1]],
            'text'        => [self::TYPE_STRING,     [Validator::MIN => 1]],
            'parse_mode'  => [self::TYPE_CONSTANTS,  TelegramParseMode::class],
        ];

    public function __construct(array $data = [])
    {
        parent::__construct($data + self::$defaults);
    }
}