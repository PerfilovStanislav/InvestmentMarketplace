<?php

namespace Controllers {

    use Core\Controller;

    class Cli extends Controller {
        function __construct() {
            parent::__construct();
        }

        final public static function fullOptimize(array $array) {
            self::optimize([
                '/assets/' => [
                    'default_skin/css/theme.clear',
                    'fullcalendar/fullcalendar.min',
                    'google/fonts',
                    'cropper/cropper',
                    'admin-forms/css/admin-forms.min',
                    'glyphicons-pro/glyphicons-pro',
                    'flags/flags',
                    'payments/payments',
                    'magnific/magnific-popup',
                ]
            ], 'css');

            self::optimize([
                '/assets/jquery/' => ['jquery-3.3.1.min', 'jquery-ui.min'],
                '/assets/' => ['magnific/jquery.magnific-popup', 'fullcalendar/lib/moment.min', 'cropper/cropper', 'pnotify/pnotify'],
                '/assets/js/' => ['utility', 'demo', 'main', 'highcharts', 'widgets', 'common', 'my-addons']
            ], 'js');

            die('OK ' . mt_rand(1, 1000));
        }

        final public static function optimize(array $arr, string $type) {
            $buffer = '';
            foreach ($arr as $dir => $files) {
                foreach ($files as $file) {
                    $f = $dir.$file.'.'.$type;
                    $buffer .= file_get_contents(ROOT.$f) . PHP_EOL;
                }
            }

            $buffer = preg_replace('/\/\*.*?\*\//si', '', $buffer);
            if ($type === 'css') {
                $buffer = str_replace(["\r\n", "\r", "\n", "\t", '  '], '', $buffer);
                $buffer = str_replace([' {', ': ', ';}', ') ', ' ('], ['{', ':', '}', ')', '('], $buffer);
            }
            else {
                $buffer = str_replace(["\t"], ' ', $buffer);
                $buffer = preg_replace("/ {2,}/", ' ', $buffer);
                $buffer = preg_replace("/;\s+/", ';', $buffer);
                $buffer = preg_replace("/,\s+/", ',', $buffer);
                $buffer = preg_replace("/\{\s+/", '{', $buffer);
                $buffer = str_replace(["\r\n", "\n\n", "\n\n\n"], "\n", $buffer);
                $buffer = preg_replace("/\}\n\}/si", '}}', $buffer);
            }

            file_put_contents(ROOT.'/assets/full.'.$type, $buffer);
            file_put_contents(ROOT.'/assets/full.'.$type.'.gz', gzencode($buffer, 9, FORCE_GZIP));
        }
    }
}