<?php

namespace App\Queries\Orders;

use App\Helpers\Sql;

class Update
{
    public static function index(
        int $id,
        int $status,
        array $data,
    )
    {
        return (new Sql(/** @lang PostgreSQL */'
            UPDATE orders
            SET status = $status, 
                data = $data
            WHERE id = $id
        ', [
            'id'      => $id,
            'status'  => $status,
            'data'    => $data,
        ]));
    }
}