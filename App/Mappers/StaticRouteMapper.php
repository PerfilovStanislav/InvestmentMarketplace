<?php

namespace App\Mappers;

use App\Controllers\Staticfiles;
use App\Dto\CustomRoute;
use App\Dto\RouteInterface;
use App\Helpers\Locales\SiteLanguageCollection;
use App\Models\Constant\Language;
use App\Views\StaticFiles\Rss;
use App\Views\StaticFiles\SiteManifest;

class StaticRouteMapper
{
    public static function get(string $uri) : ?RouteInterface {
        switch ($uri) {
            case 'site.webmanifest':
                return new CustomRoute(Staticfiles::class, 'sitemanifest'); /** @see Staticfiles::sitemanifest() */ /** @see SiteManifest */
            case 'sitemap.xml':
                return new CustomRoute(Staticfiles::class, 'sitemap');      /** @see Staticfiles::sitemap() */      /** @see Sitemap */
        }

        foreach (SiteLanguageCollection::LANGUAGES as $langId => $localClass) {
            if ($uri === sprintf('rss-%s.xml', $lang = Language::getConstNameLower($langId))) {
                App()->locale()->setLanguage($lang);
                return new CustomRoute(Staticfiles::class, 'rss'); /** @see Staticfiles::rss() */  /** @see Rss */
            }
        }

        return null;
    }
}
