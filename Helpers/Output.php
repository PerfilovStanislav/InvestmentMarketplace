<?php

namespace Helpers {

    use Controllers\Users;
    use Core\Database;
    use Core\View;
    use Models\Constant\Views;
    use Views\Investment\ChatMessage;
    use Views\Layout;

    class Output
    {
        CONST
            DOCUMENT        = 'document',
            VIEW            = 'view',
            FUNCTION        = 'function',
            ALERT           = 'alert',
            FIELD           = 'field',
            DANGER_TYPE     = 'danger',
            SUCCESS_TYPE    = 'success',
            INFO_TYPE       = 'info';

        CONST
            JSON = 'Content-type:application/json',
            E404 = 'HTTP/1.0 404 Not Found',
            E500 = 'HTTP/1.0 500 Internal Server Error';

        public static $result = [];
        private static $inProcess = false;

        public static function header(... $heads) {
            foreach ($heads as $head) {
                header($head);
            }
        }

        private static function addObjectType(string $type, string $objectName, array $params = [], string $scope = self::DOCUMENT, ?int $priority = null) {
            if ($priority) $link = &self::$result[$type][$priority][$scope][$objectName];
            else $link = &self::$result[$type][$scope][$objectName];
            $link = array_merge($link ?? [], $params);
            unset($link);
        }

        private static function addObjectTypes(string $type, array $functions, string $scope = self::DOCUMENT, int $priority = null) {
            foreach ($functions as $functionName => $params) {
                if (is_numeric($functionName)) self::addObjectType($type, $params, [], $scope, $priority);
                else self::addObjectType($type, $functionName, $params, $scope, $priority);
            }
        }
        
        public static function addFunction(string $functionName, array $params = [], string $scope = Views::CONTENT, int $priority = 10) {
            self::addObjectType(self::FUNCTION, $functionName, $params, $scope, $priority);
        }

        public static function addFunctions(array $functions, string $scope = Views::CONTENT, int $priority = 10) {
            self::addObjectTypes(self::FUNCTION, $functions, $scope, $priority);
        }

        public static function addView(string $viewName, array $params = [], string $scope = Views::CONTENT) {
            self::addObjectType(self::VIEW, $viewName, $params, $scope);
        }

        public static function addViews(array $views, string $scope = Views::CONTENT) {
            self::addObjectTypes(self::VIEW, $views, $scope);
        }

        public static function addFieldStatus(string $field, string $type, string $text, string $scope = Views::CONTENT) {
            self::addObjectType(self::FIELD, $field, [$type => $text], $scope);
        }

        public static function addFieldSuccess(string $field, string $text, string $scope = Views::CONTENT) {
            self::addFieldStatus($field, self::SUCCESS_TYPE, $text, $scope);
        }

        public static function addFieldDanger(string $field, string $text, string $scope = Output::DOCUMENT) {
            self::addFieldStatus($field, self::DANGER_TYPE, $text, $scope);
        }

        // error primary info success warning danger alert system dark success
        public static function addAlert(string $type, string $title, string $text) {
            self::addObjectType(self::ALERT, $type, [$title => $text]);
        }

        public static function addAlertSuccess(string $title, string $text) {
            self::addAlert(self::SUCCESS_TYPE, $title, $text);
        }

        public static function addAlertDanger(string $title, string $text) {
            self::addAlert(self::DANGER_TYPE, $title, $text);
        }

        public static function result() : bool {
            if (!self::$inProcess) {
                self::$inProcess = true;
            } else {
                return false;
            }
            return IS_AJAX ? self::json(self::views()) : self::layoutWithViews();
        }

        public static function views() : array {
            if (isset(self::$result[self::FUNCTION])) {
                ksort(self::$result[self::FUNCTION]);
            }

            uksort(self::$result, function($first, $second) {
                $priority = [self::VIEW => 10, self::FUNCTION => 20, self::FIELD => 30, self::ALERT => 40];
                return $priority[$first] - $priority[$second];
            });

            foreach(self::$result[self::VIEW]??[] as $dom => $views) {
                foreach ($views as $viewPath => $params) {
                    self::$result[self::VIEW][$dom] = (new View($viewPath, $params))->get();
                }
            }
            return self::$result;
        }

        private static function layoutWithViews() {
            Users::setUserHead();
            Users::setLeftSide();
            self::views();

            foreach ([self::FUNCTION, self::FIELD, self::ALERT] as $type) {
                if (self::$result[$type] ?? null) {
                    self::$result[self::VIEW][$type] = self::$result[$type];
                    unset (self::$result[$type]);
                }
            }

            // Дополнительные вьюшки
            $chatMessage = new View(ChatMessage::class);

            return Output::output((new View(Layout::class, self::$result[self::VIEW] + [
                    Views::CHAT_MESSAGE => $chatMessage,
                ]))->get());
        }

        public static function json(array $arr) {
            self::header(self::JSON);
            return self::output(json_encode($arr));
        }

        public static function output(string $output) : bool {
            Database::endTransaction();
            echo $output;
            return !0 & die();
        }
    }
}
