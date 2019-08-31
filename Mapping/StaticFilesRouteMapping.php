<?php

namespace Mapping;

use Controllers\Staticfiles;
use Views\StaticFiles\SiteManifest;

class StaticFilesRouteMapping
{
    public static function get(string $uri) : ?string {
        return [
            '/site.webmanifest' => '/Staticfiles/sitemanifest', /** @see Staticfiles::sitemanifest() */ /** @see SiteManifest */
        ][$uri] ?? null;
    }
}