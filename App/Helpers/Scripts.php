<?php

namespace App\Helpers;

class Scripts {
    public const
        ASSETS_DIR = '/assets/',

        CSS = [
            [
                'full/' => ['full'],
            ],
            [
                '' => [
    //                'default_skin/css/theme',
//                    'fullcalendar/fullcalendar',
//                    'cropper/cropper',
                    'admin-forms/css/admin-forms',
                    'flags/flags',
                    'payments/payments',
                    'magnific/magnific-popup',
                ],
                'css/' => [
                    'font',
                    'color',
                    'flex',
                    'theme.clear'
                ],
                'plugins/' => [
                    'litepicker/litepicker',
                ],
                'fonts/' => [
                    'google/fonts',
                    'admindesigns/admindesigns',
                    'glyphicons-pro/glyphicons-pro',
//                    'glyphicons/glyphicons',
                    'font-awesome/font-awesome',
                ]
            ]
        ],

        JS = [
            [
                'full/' => ['full'],
            ],
            [
                'jquery/' => ['jquery-3.6.0.min', 'jquery-ui.min'],
                '' => [
                    'magnific/jquery.magnific-popup',
                    'js/moment.min',
//                    'cropper/cropper',
                    'pnotify/pnotify',
                ],
                'plugins/' => [
                    'litepicker/litepicker',
                ],
                'js/' => ['utility', 'demo', 'main', 'highcharts'/*, 'widgets'*/, 'common', 'chat', 'my-addons']
            ]
        ];

    public static function loadJS(): void {
        foreach (self::JS[(int)DEBUG] as $dir => $files) {
            foreach ($files as $file) {
                $f = self::ASSETS_DIR.$dir.$file.'.js';
                $t = filectime(ROOT.$f);
                echo "<script src=\"$f?$t\"></script>";
            }
        }
    }

    public static function loadCSS(): void {
        foreach (self::CSS[(int)DEBUG] as $dir => $files) {
            foreach ($files as $file) {
                $f = self::ASSETS_DIR.$dir.$file.'.css';
                $t = filectime(ROOT.$f);
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$f?$t\">";
            }
        }
    }
}
