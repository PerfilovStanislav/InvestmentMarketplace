<?php

namespace App\Queries\Investment;

use App\Helpers\Sql;

class ProjectLanguages
{
    public static function index(
        int $statusId
    )
    {
        return (new Sql(/** @lang PostgreSQL */'
            SELECT
                  l.id
                , l.name
                , l.own_name
                , l.flag
                , l.shortname
                , _pl.cnt
            FROM (
                SELECT
                    pl.lang_id,
                    count(*) as cnt
                FROM project p
                JOIN project_lang pl ON pl.project_id = p.id
                WHERE p.status_id = $status_id
                GROUP BY pl.lang_id
            ) _pl
            INNER JOIN languages l
                ON _pl.lang_id = l.id
        ', [
            'status_id' => $statusId
        ]));
    }
}
