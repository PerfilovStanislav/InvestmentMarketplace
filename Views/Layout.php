<?php
namespace Views\Layout;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>RichInme - <?=$this->locale['site_title']?></title>
    <meta name="keywords" content="Bootstrap 3 Admin Dashboard Template Theme"/>
    <meta name="description" content="RichInMe - Bootstrap 3 Admin Dashboard Theme">
    <meta name="author" content="RichInMe">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <? \Helpers\Scripts::css(
        [
            '/assets/default_skin/css/' => ['theme', 'base64'],
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
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <!--[if lt IE 9]>
    <script src="/assets/js/3.7.0/html5shiv.js"></script>
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
            <?php echo $this->content; ?>
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

<?= (new \Core\View(\Views\Investment\ChatMessage::class, []))->get() ?>

<? \Helpers\Scripts::js(
    [
        '/assets/jquery/' => ['jquery-3.3.1.min', 'jquery-ui.min'],
        '/assets/' => ['magnific/jquery.magnific-popup', 'fullcalendar/lib/moment.min', 'cropper/cropper', 'pnotify/pnotify'],
        '/assets/js/' => ['utility', 'demo', 'main', 'highcharts', 'widgets', 'common', 'my-addons']
    ]
) ?>

<?php if ($this->f): ?>
    <script>
        applyFunctions('f',  <?=json_encode($this->f)?>);
    </script>
<?php endif; ?>
</body>
</html>