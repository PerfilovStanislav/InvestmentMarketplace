<?php

use App\Exceptions\ErrorException;

if (DEBUG) {
    define('MEMORY_USAGE', memory_get_usage(false));
    define('START_TIME', microtime(true));
}

function dd(...$data) {
    if (DEBUG) {
        $result = [
            'data' => (array)$data,
            'debug' => debug_backtrace(),
            'performance' => [
                'memory_get_peak_usage(true)' => memory_get_peak_usage(true) / 1024,
                'memory_get_peak_usage' => memory_get_peak_usage(false) / 1024,
                'memory_get_usage(true)' => memory_get_usage(true) / 1024,
                'memory_get_usage(false)' => (memory_get_usage(false) - MEMORY_USAGE) / 1024,
                'time' => microtime(true) - START_TIME,
            ],
        ];
        if (IS_AJAX) {
            Output()->addFunction('showInConsole', $result);
            throw new ErrorException();
        } elseif (CLI) {
            (new \Symfony\Component\VarDumper\Dumper\CliDumper())->dump(
                (new \Symfony\Component\VarDumper\Cloner\VarCloner())->cloneVar($data)
            );
            die();
        }
        else {
            echo '<pre>', print_r($result, true), '</pre>';
            die();
        }
    }
}
