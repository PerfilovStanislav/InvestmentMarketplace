<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Output;
use App\Views\StaticFiles\Rss;
use App\Views\StaticFiles\SiteManifest;
use App\Views\StaticFiles\Sitemap;

class Staticfiles extends Controller {

    public function sitemanifest(array $data = []): Output {
        return Output()
            ->disableLayout()
            ->addContentTypeHeader(Output::MANIFEST)
            ->addView(SiteManifest::class);
    }

    public function sitemap(array $data = []): Output {
        $data = Db()->setTable('mv_sitemapxml')->select();

        return Output()
            ->disableLayout()
            ->addContentTypeHeader(Output::XML)
            ->addView(Sitemap::class, ['data' => $data]);
    }

    public function rss(array $data = []): Output {
        Output()->disableMinifying();
        $data = Db()->setTable('mv_sitemapxml')->select(['shortname' => App()->locale()->getLanguage()]);

        return Output()
            ->disableLayout()
            ->addContentTypeHeader(Output::XML)
            ->addView(Rss::class, ['data' => $data]);
    }
}
