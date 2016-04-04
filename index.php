<?php
namespace {
    define('SITE', '/MyFirstMVC/');
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    spl_autoload_extensions(".php");
    spl_autoload_register(function ($className) {
        require_once($className . ".php");
    });

    new Core\Router();
}


