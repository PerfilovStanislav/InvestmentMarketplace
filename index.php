<?php
namespace {
    define('DIR', dirname($_SERVER['SCRIPT_NAME']));
    define('SITE', str_replace('//', '/', DIR.'/'));
    define('DOMAIN', '127.0.0.1');
    error_reporting(E_ALL | E_STRICT);
    define('IS_AJAX', ($_POST['ajax'] ?? 0) == 1 || isset($_SERVER['HTTP_X_REQUESTED_WITH']));
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    spl_autoload_extensions(".php");
    function real_path($path) {
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    }
    spl_autoload_register(function ($className) {
        require_once(real_path($className) . ".php");
    });

    new Core\Router();
}


