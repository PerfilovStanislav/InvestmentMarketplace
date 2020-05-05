<?php

namespace Requests\Telegram;

use Core\AbstractEntity;
use Requests\Telegram\Dto\CallbackQuery;

/**
 * @property int           $update_id
 * @property CallbackQuery $callback_query
 */
class WebhookRequest extends AbstractEntity {

    protected static array
        $properties = [
            'update_id'      => [self::TYPE_INT, []],
            'callback_query' => [self::TYPE_DTO, CallbackQuery::class],
        ];
}