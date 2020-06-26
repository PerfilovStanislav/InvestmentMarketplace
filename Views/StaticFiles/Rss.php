<?php
namespace Views\StaticFiles; {
/**
 * @var Sitemap $this
 * @property array $data
 * @property AbstractLanguage $locale
 */
Class Rss {} }

use Helpers\Locales\AbstractLanguage;
use Libraries\Screens; ?>
<?="<?xml version='1.0' encoding='UTF-8'?>"?>
<rss xmlns:yandex="http://news.yandex.ru"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:turbo="http://turbo.yandex.ru"
     version="2.0">
    <channel>
        <title><?=Translate()->headTitle?></title>
        <link><?=SITE?></link>
        <description><?=Translate()->headDescription?></description>
        <language><?=App()->locale()->getLanguage()?></language>
        <turbo:analytics type="Yandex" id="65203048"></turbo:analytics>
        <yandex:analytics type="Google" id="UA-98100813-2"></yandex:analytics>
        <?php foreach ($this->data as $info): ?>
        <item turbo="true">
            <!-- Информация о странице -->
            <link><?=$url=sprintf('%s/Investment/details/site/%s/lang/%s', SITE, $info['url'], App()->locale()->getLanguage())?></link>
            <turbo:source><?=$url?></turbo:source>
            <turbo:topic><?=$info['name']?></turbo:topic>
<!--            <pubDate>Tue, 21 Apr 2015 14:15:00 +0300</pubDate>-->
            <pubDate><?=$info['add_date']?></pubDate>
            <author>Perfilov Stanislav</author>
            <metrics>
                <yandex schema_identifier="main-page">
                    <breadcrumblist>
                        <breadcrumb url="<?=SITE?>/Contact/show" text="<?=Translate()->contact?>"/>
                        <breadcrumb url="<?=SITE?>/Investment/registration" text="<?=Translate()->addProject?>"/>
                    </breadcrumblist>
                </yandex>
            </metrics>
<!--            <yandex:related></yandex:related>-->
            <turbo:content>
                <![CDATA[
                <header>
                    <h1><?=$info['name']?></h1>
                    <figure>
                        <img src="<?=SITE?>/<?=Screens::getOriginalJpgScreen($info['id'])?>">
                    </figure>
                    <menu>
                        <a href="<?=SITE?>/Contact/show"><?=Translate()->contact?></a>
                        <a href="<?=SITE?>/Investment/registration"><?=Translate()->addProject?></a>
                    </menu>
                    <p><?=str_replace(['<\br>', "\n"], '</p><p>', $info['description'] ?? '')?>
                    </p>
                </header>
                ]]>
            </turbo:content>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>

