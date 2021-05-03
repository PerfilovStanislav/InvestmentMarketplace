<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Scripts;

class Cli extends Controller {

    public static function fullOptimize() {
        self::optimize(Scripts::CSS[1], 'css');

        self::optimize(Scripts::JS[1], 'js');

        die('OK ' . mt_rand(1, 1000));
    }

    public static function optimize(array $arr, string $type): void {
        $buffer = '';
        foreach ($arr as $dir => $files) {
            foreach ($files as $file) {
                $f = Scripts::ASSETS_DIR.$dir.$file.'.'.$type;
                $buffer .= file_get_contents(ROOT.$f) . PHP_EOL;
            }
        }

        $buffer = preg_replace('/\/\*.*?\*\//si', '', $buffer);
        if ($type === 'css') {
            $buffer = str_replace(
                ["\r\n", "\r", "\n", "\t", '   ', ' {', ': ', ';}', ') ', ' ('],
                [''    , ''  , ''  , ''  , ''   , '{' , ':' , '}' , ')' , '(' ],
                $buffer
            );
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

        $path = ROOT.'/assets/full/full.';
        file_put_contents($path.$type, $buffer);
//        file_put_contents($path.$type.'.gz', gzencode($buffer, 9, FORCE_GZIP));
//        file_put_contents($path.$type.'.br', brotli_compress($buffer, 9, 11));
    }
}
