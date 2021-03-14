<?php

namespace App\Queries\Investment;

use App\Helpers\Sql;

class GetProjects
{
    public static function index(
        int $statusId,
        int $langId,
        int $limit = 10
    )
    {
        return (new Sql(/** @lang PostgreSQL */'
            SELECT
                  p.id
                , p.name
                , p.admin
                , p.url
                , p.url
                , p.start_date
                , p.add_date
                , p.add_date
                , p.paymenttype
                , p.ref_percent
                , p.plan_percents
                , p.plan_period
                , p.plan_period_type
                , p.currency
                , p.min_deposit
                , p.id_payments
                , p.ref_url
                , p.status_id
                , p.rating
                , p.scam_date
            FROM project p
            INNER JOIN project_lang pl
                ON pl.project_id = p.id
                AND pl.lang_id = $lang_id
            WHERE status_id = $status_id
            ORDER BY id desc
            LIMIT $limit
        ', [
            'status_id' => $statusId,
            'lang_id'   => $langId,
            'limit'     => $limit,
        ]));
    }
}
