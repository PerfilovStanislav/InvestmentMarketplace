<?php

use Core\App;
use Core\Database;
use Core\Router;
use Helpers\Errors;
use Helpers\Locales\AbstractLanguage;
use Helpers\Output;
use Models\CurrentUser;
use Requests\Telegram\SendMessageRequest;
use Exceptions\ErrorException;

define('DIR', dirname($_SERVER['SCRIPT_NAME']));
define('ROOT', __DIR__);
define('DOMAIN', 'richinme.org');
define('SITE', 'https://' . DOMAIN);
define('WEBP', strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'webp') !== false);
define('CLI', php_sapi_name() === 'cli');
error_reporting(E_ALL | E_STRICT);
define('IS_AJAX', ($_POST['ajax'] ?? 0) == 1 || isset($_SERVER['HTTP_X_REQUESTED_WITH']));
define('START_SHUTDOWN', true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

spl_autoload_extensions('.php');
function real_path(string $path): string {
    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, CLI ? DIR . '/' . $path : $path);
}
function load(string $className) {
    require_once(real_path($className) . '.php');
}
spl_autoload_register('load');

define('DEBUG', ($_COOKIE['XDEBUG_SESSION'] ?? '') === Config::DEBUG_KEY || CLI);

require_once real_path('Helpers/Debug.php');

register_shutdown_function('shutdown');

function App(): App {
    return App::getInstance();
}
function Db(): Database {
    return App()->db();
}
function Router(): Router {
    return App()->router();
}
function Output(): Output {
    return App()->output();
}
function Error(): Errors {
    return App()->error();
}
function Translate(): AbstractLanguage {
    return App()->locale()->translate();
}
function CurrentUser(): CurrentUser {
    return App()->currentUser();
}
if (CLI) {
    Router()->go($argv[1]);
}
else {
    try {
        App()->start();
    } catch (ErrorException $exception) {
        Db()->rollBackTransaction();
    } catch (\Exception $exception) {
        Db()->rollBackTransaction();
        sendToTelegram(['errorMessage' => $exception->getMessage()]);
    }
}

die();

function shutdown() {
    if ($error = error_get_last()) { // E_COMPILE_ERROR, E_CORE_ERROR, E_ERROR, E_PARSE
//        sendToTelegram(['error' => $error]);
    }
}

function sendToTelegram(array $data = []) {
    App()->telegram()->sendMessage(new SendMessageRequest([
        'chat_id' => \Config::TELEGRAM_MY_ID,
        'text' => '```' . print_r([
            'data' => $data,
            'debug' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),
            'request' => $_REQUEST,
            'URI' =>  $_SERVER['REQUEST_URI'] ?? '',
            'referer' =>  $_SERVER['HTTP_REFERER'] ?? '',
        ], true) . '```',
    ]));
}
