<?php

namespace Helpers {

    use Controllers\Users;
    use Core\View;
    use Views\Layout as ViewLayout;

    class Helper
    {
        CONST
            JSON = 'Content-type:application/json',
            E404 = 'HTTP/1.0 404 Not Found',
            E500 = 'HTTP/1.0 500 Internal Server Error',
            GZIP = 'Content-Encoding: gzip';

        public static $r = [];

        final public static function header(... $heads) {
            foreach ($heads as $head) {
                header($head);
            }
        }

        final public static function result() : bool {
            self::sort();
            return IS_AJAX ? self::json(self::view()) : self::layout();
        }

        private final static function sort() {
            uksort(self::$r, function($a, $b) {
                $m = ['c' => 100, 'f' => 50, 'alert' => 25];
                return $m[$b] - $m[$a];
            });
        }

        final private static function layout() {
            Users::setUserHead();
            Users::setLeftSide();
            uksort(self::$r['f'], function($a, $b) {
                return $a == 'document' ? -1 : 1;
            });
            self::view();

            if (self::$r['f']??false) {
                self::$r['c']['f'] = self::$r['f'];
                unset (self::$r['f']);
            }

            return Helper::gzip((new View(ViewLayout::class, self::$r['c']))->get());
        }

        final public static function json(array $arr) {
            self::header(self::JSON);
            return self::gzip(json_encode($arr));
        }

        // error primary info success warning danger alert system dark success
        final public static function alert(array $arr, string $type) {
            self::$r['alert'][$type] = $arr;
        }

        final public static function success(array $arr, string $scope = 'content') {
            return self::out($arr, $scope, 'success');
        }

        final public static function error(array $arr, string $scope = 'content') {
            return !self::out($arr, $scope, 'error');
        }

        final private static function out(array $arr, string $scope, string $type) {
            return self::json([$type => [$scope => $arr]]);
        }

        final public static function view() : array {
            foreach(self::$r['c']??[] as $k => $v) {
                self::$r['c'][$k] = (new View($v[0], $v[1]))->get();
            }
            return self::$r;
        }

        final public static function fieldError(string $field, string $key, string $scope= 'content') {
            return self::error(['fields' => [$field => Locale::get($key)]], $scope);
        }

        final public static function fieldSuccess(string $field, string $key, string $scope= 'content') {
            return self::success(['fields' => [$field => Locale::get($key)]], $scope);
        }

        final public static function gzip(string $output) : bool {
            /*if (mb_strlen($output) > 1024) {
                $encoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';

                foreach (['deflate', 'gzip', 'x-gzip'] as $v) {
                    if (strpos($encoding, $v) !== false) {
                        self::header(self::GZIP);
                        echo gzencode($output, 2, FORCE_GZIP);
                        return !0 & die();
                    }
                }
            }*/

            echo $output;
            return !1 & die();
        }
    }
}
