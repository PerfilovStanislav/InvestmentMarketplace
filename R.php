<?php
declare(strict_types=1);

namespace  {

    class R {
        private function __construct() {
        }

        final public static function r(array $data) {
            $f = debug_backtrace();
            echo sprintf("%s->%s:%d", $f[1]['class']??'', $f[1]['function'], $f[0]['line']).'<pre>';
            echo print_r($data,true)."</pre>";

            die();
        }
    }

}