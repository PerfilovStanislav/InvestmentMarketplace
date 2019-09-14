<?php

namespace Helpers;

class Scripts {
    CONST
        ASSETS_DIR = '/assets/',

        CSS = [
            [
                'full/' => ['full'],
            ],
            [ '' => [
                'default_skin/css/theme.clear',
//                'default_skin/css/theme',
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
        ],

        JS = [
            [
                'full/' => ['full'],
            ],
            [
                'jquery/' => ['jquery-3.4.1.min', 'jquery-ui.min'],
                '' => ['magnific/jquery.magnific-popup', 'fullcalendar/lib/moment.min', 'cropper/cropper', 'pnotify/pnotify'],
                'js/' => ['utility', 'demo', 'main', 'highcharts', 'widgets', 'common', 'chat', 'my-addons']
            ]
        ];

    public static function loadJS(int $debug) {
        $storage = ['js/locales/' => [Locale::getLanguage()]] + self::JS[$debug];
        foreach ($storage as $dir => $files) {
            foreach ($files as $file) {
                $f = self::ASSETS_DIR.$dir.$file.'.js';
                $t = filemtime(ROOT.$f);
                echo '<script src="'.$f.'?'.$t.'"></script>';
            }
        }
    }

    public static function loadCSS(int $debug) {
        foreach (self::CSS[$debug] as $dir => $files) {
            foreach ($files as $file) {
                $f = self::ASSETS_DIR.$dir.$file.'.css';
                $t = filemtime(ROOT.$f);
                echo '<link rel="stylesheet" type="text/css" href="'.$f.'?'.$t.'">';
            }
        }
    }
}
