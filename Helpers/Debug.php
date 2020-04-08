<?php

if (DEBUG) {
    define('MEMORY_USAGE', memory_get_usage(false));
    define('START_TIME', microtime(true));
}

function dd(...$data) {
    if (DEBUG) {
        $result = [
            'data' => (array)$data,
            'performance' => [
                'memory_get_peak_usage(true)' => memory_get_peak_usage(true) / 1024,
                'memory_get_peak_usage' => memory_get_peak_usage(false) / 1024,
                'memory_get_usage(true)' => memory_get_usage(true) / 1024,
                'memory_get_usage(false)' => (memory_get_usage(false) - MEMORY_USAGE) / 1024,
                'time' => microtime(true) - START_TIME,
            ],
            'debug' => debug_backtrace(),
        ];
        if (IS_AJAX) {
            Output()->addFunction('showInConsole', $result);
        } else {
            Output()->addView(\Views\Errors\Debug::class, ['debug' => $result]);
        }
        throw new ErrorException();
    }
}
