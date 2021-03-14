<?php

namespace App\Queries\Investment;

use App\Helpers\Sql;

class SitemapXml
{
    public static function index(
        string $shortname = null
    )
    {
        return (new Sql(/** @lang PostgreSQL */'
            SELECT 
                p.id,
                p.name,
                p.add_date,
                p.url,
                l.shortname,
                pl.description
            FROM project p
                JOIN project_lang pl ON pl.project_id = p.id
                JOIN languages l ON pl.lang_id = l.id
            WHERE p.status_id = 1 $shortname
            ORDER BY p.add_date DESC;
        ', [
            'shortname' => $shortname !== null
                ? new Sql('AND l.shortname = $v', ['v' => $shortname])
                : new Sql()
        ]));
    }
}
