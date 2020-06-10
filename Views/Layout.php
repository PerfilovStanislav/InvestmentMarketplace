<?php
namespace Views; {
/**
 * @var Layout $this
 * @package Views
 * @property AbstractLanguage $locale
 */
Class Layout {}}

use Helpers\Locales\AbstractLanguage;
use Helpers\Output;
use Models\Constant\Views;
?>
<!DOCTYPE html>
<html lang="<?=App()->locale()->getLanguage()?>" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <?=$this->{Views::META}?>
    <meta name="author" content="RichInMe">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">

    <link rel="shortcut icon" href="/assets/icons/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/assets/icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="RiM">
    <meta name="application-name" content="RiM">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">
    <meta name="yandex-verification" content="0cb92639e17a4017" />

    <?php \Helpers\Scripts::loadCSS() ?>
</head>

<body class="dashboard-page">
<div id="main">
    <header class="navbar navbar-fixed-top navbar-shadow">
        <div class="navbar-branding">
            <img src="/assets/icons/qr-code.svg" class="logo-qr" href="/assets/icons/qr-code.svg" title="QR code site">
            <a class="navbar-brand" href="/">
                <b class="first">Rich</b><b class="second">inMe</b>
            </a>
            <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
        </div>
        <div id="<?=Views::USER_HEAD?>" class="animated fadeIn">
            <?=$this->{Views::USER_HEAD}?>
        </div>
    </header>
    <aside id="<?=Views::SIDEBAR_LEFT?>" class="nano nano-light affix">
        <?=$this->{Views::SIDEBAR_LEFT}?>
    </aside>
    <section id="content_wrapper">
        <div id="<?=Views::CONTENT;?>" class="animated fadeIn">
            <?=$this->{Views::CONTENT}?>
        </div>
    </section>
</div>
<div hidden>
    <div class="alert alert-dismissable alert-micro alert-border-left mrn mln" id="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-warning pr10"></i>
        <er>{error}</er>
    </div>
</div>

<?=$this->{Views::CHAT_MESSAGE}?>

<?php \Helpers\Scripts::loadJS() ?>

<script id="scripts">
    <?php foreach ([Output::FUNCTION, Output::FIELD, Output::ALERT] as $type) {
    if (isset($this->{$type})) { ?>
        applyFunctions('<?=$type?>', <?=json_encode($this->{$type})?>);
    <?php }} ?>
</script>
</body>
</html>