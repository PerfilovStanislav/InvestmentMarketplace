<?php

namespace Requests\Telegram;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Constant\TelegramParseMode;

/**
 * @property int    $chat_id
 * @property string $caption
 * @property string $parse_mode
 * @property \CURLFile $photo
 */
class SendPhotoRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = [
            'parse_mode' => TelegramParseMode::MARKDOWN,
        ],
        $properties = [
            'chat_id'     => [self::TYPE_INT,        [Validator::MIN => 1]],
            'photo'       => [self::TYPE_CURL_FILE,  [Validator::MIN => 1]],
            'parse_mode'  => [self::TYPE_CONSTANTS,  TelegramParseMode::class],
            'caption'     => [self::TYPE_STRING,     [Validator::MIN => 0]],
        ];

    public function __construct(array $data = [])
    {
        parent::__construct($data + self::$defaults);
    }
}