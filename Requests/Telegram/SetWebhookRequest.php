<?php

namespace Requests\Telegram;

use Core\AbstractEntity;
use Helpers\Validator;

/**
 * @property string    $url
 * @property \CURLFile $certificate
 * @property int       $max_connections
 */
class SetWebhookRequest extends AbstractEntity {

    protected static array
        $properties = [
            'url'             => [self::TYPE_STRING,     [Validator::MIN => 1]],
            'certificate'     => [self::TYPE_CURL_FILE,  [Validator::MIN => 1]],
            'max_connections' => [self::TYPE_INT,        [Validator::MIN => 1, Validator::MAX => 100]],
        ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}