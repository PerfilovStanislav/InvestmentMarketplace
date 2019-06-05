<?php

namespace {
    use Core\Auth;

    define('DIR', dirname($_SERVER['SCRIPT_NAME']));
    define('ROOT', dirname(__FILE__));
    define('DOMAIN', 'richinme.org');
    error_reporting(E_ALL | E_STRICT);
    define('IS_AJAX', ($_POST['ajax'] ?? 0) == 1 || isset($_SERVER['HTTP_X_REQUESTED_WITH']));
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    spl_autoload_extensions(".php");
    function real_path($path) {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }
    spl_autoload_register(function ($className) {
        require_once(real_path($className) . ".php");
    });

    Auth::getInstance();
    (Core\Router::getInstance())->setUri()->startRoute();
}
