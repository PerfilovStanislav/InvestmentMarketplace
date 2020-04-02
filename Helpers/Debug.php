<?php

if (DEBUG) {
    define('MEMORY_USAGE', memory_get_usage(false));
    define('START_TIME', microtime(true));
}

function dd(...$data)
{
    if (DEBUG) {
        echo
        '<pre>',
        print_r((array)$data, true),
        print_r([
            'memory_get_peak_usage(true)' => memory_get_peak_usage(true) / 1024,
            'memory_get_peak_usage' => memory_get_peak_usage(false) / 1024,
            'memory_get_usage(true)' => memory_get_usage(true) / 1024,
            'memory_get_usage(false)' => (memory_get_usage(false) - MEMORY_USAGE) / 1024,
            'time' => microtime(true) - START_TIME,
        ], true),
        print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true),
        '</pre>',
        die;
    }
}
