<?php

namespace Mappers;

use Controllers\Staticfiles;
use Dto\CustomRoute;
use Dto\RouteInterface;
use Views\StaticFiles\SiteManifest;

class StaticRouteMapper
{
    public static function get(string $uri) : ?RouteInterface {
        switch ($uri) {
            case 'site.webmanifest':
                return new CustomRoute(Staticfiles::class, 'sitemanifest'); /** @see Staticfiles::sitemanifest() */ /** @see SiteManifest */
            case 'sitemap.xml':
                Output()->disableMinifying();
                return new CustomRoute(Staticfiles::class, 'sitemap');      /** @see Staticfiles::sitemap() */      /** @see Sitemap */
        }

        return null;
    }
}
