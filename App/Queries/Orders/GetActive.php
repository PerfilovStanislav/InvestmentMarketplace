<?php

namespace App\Queries\Orders;

use App\Helpers\Sql;
use App\Models\Constant\OrderStatus;
use App\Models\Constant\OrderType;

class GetActive
{
    public static function index(int $pos, bool $webp)
    {
        return (new Sql(/** @lang PostgreSQL */'
            SELECT 
                b.path || $webp as path, 
                b.url as url
            FROM order_banners b
            INNER JOIN orders o
                ON o.entity_id = b.id
                AND o.type = $type
                AND o.status = $status
            WHERE now() >= b.date_from
                AND now() < b.date_to + 1
                AND b.pos = $pos
        ', [
            'status'  => OrderStatus::SUCCESS,
            'type'    => OrderType::BANNER,
            'pos'     => $pos,
            'webp'    => $webp ? '.webp' : '',
        ]));
    }
}
