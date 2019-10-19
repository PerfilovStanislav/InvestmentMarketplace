<?php

namespace {
    Class Index {};

    use Core\Auth;
    use Core\Database;

    define('DIR', dirname($_SERVER['SCRIPT_NAME']));
    define('ROOT', dirname(__FILE__));
    define('DOMAIN', 'richinme.com');
    define('SITE', 'https://' . DOMAIN);
    define('WEBP', strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'webp') !== false);
    define('DEBUG', 0);
    error_reporting(E_ALL | E_STRICT);
    define('IS_AJAX', ($_POST['ajax'] ?? 0) == 1 || isset($_SERVER['HTTP_X_REQUESTED_WITH']));
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    spl_autoload_extensions('.php');
    function real_path($path) {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }
    spl_autoload_register(function ($className) {
        require_once(real_path($className) . '.php');
    });

    function dd(... $data) {
        echo '<pre>', print_r((array)$data,true), print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true), '</pre>', die;
    }

    try {
        Auth::getInstance();
        (Core\Router::getInstance())->setUri()->startRoute();
    } catch (\Exception $exception) {
        Database::rollBackTransaction();
        dd($exception);
    }
}
