<?php

namespace App\Queries\Investment;

use App\Helpers\Sql;

class ProjectAvailableLanguages
{
    public static function index(
        int $statusId
    )
    {
        return (new Sql(/** @lang PostgreSQL */'
            SELECT 
                pl.lang_id,
                p.status_id,
                count(*) AS cnt
            FROM project p
            JOIN project_lang pl ON pl.project_id = p.id
            WHERE p.status_id = $status_id
            GROUP BY p.status_id, pl.lang_id
            ORDER BY p.status_id, (count(*)) DESC;
        ', [
            'status_id' => $statusId
        ]));
    }
}
