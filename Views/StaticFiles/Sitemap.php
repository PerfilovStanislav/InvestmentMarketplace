<?php
namespace Views\StaticFiles; {
/**
 * @var Sitemap $this
 * @property array $data
 * @property AbstractLanguage $locale
 */
Class Sitemap {} }

use Helpers\Locales\AbstractLanguage;
use Libraries\Screens; ?>
<?="<?xml version='1.0' encoding='UTF-8'?>"?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
>
    <?php foreach ($this->data as $info): ?>
        <url>
            <loc><?=SITE?>/Investment/details/site/<?=$info['url']?>/lang/<?=$info['shortname']?></loc>
            <lastmod><?=$info['add_date']?></lastmod>
            <changefreq>never</changefreq>
            <priority>1</priority>
            <image:image>
                <image:loc><?=SITE?>/<?=Screens::getOriginalJpgScreen($info['id'])?></image:loc>
                <image:caption>Official site <?=$info['name']?></image:caption>
                <image:geo_location>Russia</image:geo_location>
                <image:title><?=$info['name']?></image:title>
            </image:image>
            <news:news>
                <news:publication>
                    <news:name><?=$info['name']?></news:name>
                    <news:language><?=$info['shortname']?></news:language>
                </news:publication>
                <news:publication_date><?=$info['add_date']?></news:publication_date>
                <news:title><?=mb_substr(str_replace(['<\br>', '<', '>', '/', '\\'], '', $info['description'] ?? ''), 0, 95)?></news:title>
                <news:genres>UserGenerated</news:genres>
                <news:keywords>business, investment</news:keywords>
            </news:news>
        </url>
    <?php endforeach; ?>
</urlset>

