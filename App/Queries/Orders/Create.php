<?php

namespace App\Queries\Orders;

use App\Helpers\Sql;

class Create
{
    public static function index(
        string  $startDate,
        string  $endDate,
        int     $pos,
        string  $url,
        string  $contact,
        int     $orderType,
        float   $sum,
        string  $path,
    )
    {
        return (new Sql(/** @lang PostgreSQL */'
            WITH _banners AS (
                INSERT INTO order_banners (date_from, date_to, pos, url, contact, path)
                VALUES ($date_from, $date_to, $pos, $url, $contact, $path)
                RETURNING id
            ), _orders AS (
                INSERT INTO orders (type, entity_id, status, sum)
                SELECT $order_type, _banners.id, 1, $sum
                FROM _banners
                RETURNING orders.id
            )
            SELECT * from _orders
        ', [
            'date_from'  => $startDate,
            'date_to'    => $endDate,
            'pos'        => $pos,
            'url'        => $url,
            'contact'    => $contact,
            'order_type' => $orderType,
            'sum'        => $sum,
            'path'       => $path,
        ]));
    }
}