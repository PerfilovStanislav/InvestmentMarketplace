<?php

namespace App\Queries\Investment;

use App\Helpers\Sql;

class Counts
{
    public static function index()
    {
        return (new Sql(/** @lang PostgreSQL */"
            WITH _new_last_month(new_last_month) AS (
                SELECT count(*)
                FROM project
                WHERE add_date >= (NOW() - INTERVAL '43830 minutes')::date
            ), _scam_last_month(scam_last_month) AS (
                SELECT count(*)
                FROM project
                WHERE project.scam_date >= (NOW() - INTERVAL '43830 minutes')::date
            ), _active(active) AS (
                SELECT count(*)
                FROM project
                WHERE status_id = 1
            ), _total(total) AS (
                SELECT count(*)
                FROM project
                WHERE status_id = ANY(ARRAY[1,2,4])
            )
            SELECT * FROM _new_last_month, _scam_last_month, _active, _total
        ", [
        ]));
    }
}
