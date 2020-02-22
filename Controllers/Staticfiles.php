<?php

namespace Controllers;

use Core\Controller;
use Helpers\Output;
use Views\StaticFiles\SiteManifest;
use Views\StaticFiles\Sitemap;

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
}
