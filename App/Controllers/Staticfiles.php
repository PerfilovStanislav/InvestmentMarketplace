<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Output;
use App\Views\StaticFiles\Rss;
use App\Views\StaticFiles\SiteManifest;
use App\Views\StaticFiles\Sitemap;

class Staticfiles extends Controller {

    public function sitemanifest(): Output {
        return Output()
            ->disableLayout()
            ->addContentTypeHeader(Output::MANIFEST)
            ->addView(SiteManifest::class);
    }

    public function sitemap(): Output {
        $data = Db()->setTable('mv_sitemapxml')->select();

        return Output()
            ->disableLayout()
            ->addContentTypeHeader(Output::XML)
            ->addView(Sitemap::class, ['data' => $data]);
    }

    public function rss(): Output {
        Output()->disableMinifying();
        $data = Db()->setTable('mv_sitemapxml')->select(['shortname' => App()->locale()->getLanguage()]);

        return Output()
            ->disableLayout()
            ->addContentTypeHeader(Output::XML)
            ->addView(Rss::class, ['data' => $data]);
    }
}
