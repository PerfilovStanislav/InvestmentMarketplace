<?
namespace Views\Layout;
?>
<!DOCTYPE html>
<html lang="<?=$this->locale['lang']?>">
<head>
    <meta charset="utf-8">
    <title>RichInme - <?=$this->locale['head']['title']?></title>
    <meta name="keywords" content="<?=$this->locale['head']['keywords']?>"/>
    <meta name="description" content="<?=$this->locale['head']['description']?>">
    <meta name="author" content="RichInMe">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/assets/icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="RiM">
    <meta name="application-name" content="RiM">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">

    <meta property="og:image:width" content="279">
    <meta property="og:image:height" content="279">
    <meta property="og:title" content="<?=$this->locale['head']['title']?>">
    <meta property="og:description" content="<?=$this->locale['head']['description']?>">
    <meta property="og:url" content="http://richinme.com">
    <meta property="og:image" content="http://richinme.com/og-image.jpg">

    <? \Helpers\Scripts::css(
        [
            '/assets/default_skin/css/' => ['theme.clear', 'base64'],
            '/assets/' => [
                'fullcalendar/fullcalendar.min',
                'google/fonts',
                'cropper/cropper',
                'admin-forms/css/admin-forms.min',
                'glyphicons-pro/glyphicons-pro',
                'flags/flags',
                'payments/payments',
                'magnific/magnific-popup',
            ]
        ]
    ) ?>

    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="dashboard-page">
<div id="main">
    <header class="navbar navbar-fixed-top navbar-shadow">
        <div class="navbar-branding">
            <a class="navbar-brand" href="dashboard.html">
                <b class="first">Rich</b><b class="second">inMe</b>
            </a>
            <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
        </div>
        <div id="userHead" class="animated fadeIn">
            <?= $this->userHead ?>
        </div>
    </header>
    <aside id="sidebar_left" class="nano nano-light affix">
        <?= $this->sidebar_left ?>
    </aside>
    <section id="content_wrapper">
        <div id="content" class="animated fadeIn">
            <?= $this->content; ?>
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

<?=(new \Core\View(\Views\Investment\ChatMessage::class, []))->get()?>

<? \Helpers\Scripts::js(
    [
        '/assets/jquery/' => ['jquery-3.3.1.min', 'jquery-ui.min'],
        '/assets/' => ['magnific/jquery.magnific-popup', 'fullcalendar/lib/moment.min', 'cropper/cropper', 'pnotify/pnotify'],
        '/assets/js/' => ['utility', 'demo', 'main', 'highcharts', 'widgets', 'common', 'my-addons']
    ]
) ?>

<? if ($this->f): ?>
    <script>
        applyFunctions('f',  <?=json_encode($this->f)?>);
    </script>
<? endif; ?>
</body>
</html>