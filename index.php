<?php

use App\Core\App;
use App\Core\Database;
use App\Core\Router;
use App\Helpers\Errors;
use App\Helpers\Locales\AbstractLanguage;
use App\Helpers\Output;
use App\Models\CurrentUser;
use App\Requests\Telegram\SendMessageRequest;
use App\Exceptions\ErrorException;

\define('DIR', \dirname($_SERVER['SCRIPT_NAME']));
const ROOT = __DIR__;
const DOMAIN = 'richinme.com';
const SITE = 'https://' . DOMAIN;
\define('WEBP',
    \strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'webp') !== false
    || ($_POST['webp'] ?? '') === 'true'
);
\define('CLI', \php_sapi_name() === 'cli');
\error_reporting(E_ALL | E_STRICT);
\define('IS_AJAX',
    ($_POST['ajax'] ?? 0) == 1
    || isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    || \strtolower($_SERVER['REQUEST_METHOD'] ?? '') === 'post'
);
\ini_set('display_errors', 1);
\ini_set('display_startup_errors', 1);

\spl_autoload_extensions('.php');
function real_path(string $path): string {
    return \str_replace(['/', '\\'], DIRECTORY_SEPARATOR, CLI ? DIR . '/' . $path : $path);
}
function load(string $className) {
    require_once(\real_path($className) . '.php');
}
\spl_autoload_register('load');

\define('DEBUG', ($_COOKIE['XDEBUG_SESSION'] ?? '') === Config::DEBUG_KEY || CLI);

require_once \real_path('App/Helpers/Debug.php');

\register_shutdown_function('shutdown');
require(ROOT . '/vendor/autoload.php');

function App(): App {
    return App::inst();
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
    } catch (ErrorException $e) {
//        Db()->rollBackTransaction();
    } catch (\Throwable $e) {
//        Db()->rollBackTransaction();
//        echo $e->getMessage(); die();
        sendToTelegram([
            'exception'     => [
                'line'      => $e->getLine(),
                'message'   => $e->getMessage(),
                'file'      => $e->getFile(),
            ]
        ]);
    }
}

function shutdown() {
    if ($error = error_get_last()) { // E_COMPILE_ERROR, E_CORE_ERROR, E_ERROR, E_PARSE
        sendToTelegram(['error' => $error]);
    }
}

function sendToTelegram(array $data = []) {
    App()->telegram()->sendMessage(new SendMessageRequest([
        'chat_id' => \Config::TELEGRAM_MY_ID,
        'text' => '```' . \print_r([
            'data' => $data,
            'debug' => \debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2),
            'request' => $_REQUEST,
            'ip' => $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.1',
            'URI' =>  $_SERVER['REQUEST_URI'] ?? '',
            'referer' =>  $_SERVER['HTTP_REFERER'] ?? '',
        ], true) . '```',
    ]));
}
