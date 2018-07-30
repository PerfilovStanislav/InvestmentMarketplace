<?php

namespace Core {
    use Helpers\{Validator};

    class Router {
        private $defaultParams = 'Hyip/registration/1';
        private $errorParams   = 'Errors/show/1';

        private $uri = null;

        private $controller;
        private $action;
        private $params;

        function __construct() {
            Auth::getInstance();
            /*
             * если не указан метод (зашли site.com), то показываем стартовую страницу
             * иначе если не получилось найти указанный метод,
             * то возвращаем ошибку
             */
            if (!$this->parseUri()->action) {
                $this->route($this->defaultParams);
            }
            else if (!$this->parseUri()->route()) {
                $this->route($this->route($this->errorParams));
            }
        }

        private function getUri() {
            $this->uri = substr($_SERVER["REQUEST_URI"], strlen(DIR));
            $this->uri = preg_replace('/[^a-zA-Z0-9-_\/]/', '', $this->uri);
            $this->uri = Validator::replace(Validator::URI, $this->uri);
            return $this;
        }

        private function parseUri($strUri = null) {
            $strUri             = $strUri ?? $this->uri ?? $this->getUri()->uri;
            $uri                = explode('/', strtolower(trim($strUri,'/')));
            $this->controller   = count($uri) ? ucfirst(array_shift($uri)) : '';
            $this->action       = count($uri) ? array_shift($uri) : null;
            $this->params       = count($uri) ? $uri : [];
            return $this;
        }

        private function route($strUri = null) {
            if ($strUri) $this->parseUri($strUri);
            $controllerClass = 'Controllers\\'.$this->controller;

            if(!file_exists(real_path($controllerClass).'.php')) { return false; }
            $controller = new $controllerClass();

            $this->params = array_map(function($a){return [$a[0] => $a[1]??null];}, array_chunk($this->params, 2));
            call_user_func_array([$controller, $this->action], $this->params);
        }
    }

}?>