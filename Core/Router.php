<?php

namespace Core {
    use Core\Database;
    use Core\Auth;

    class Router {
        private $defaultParams = 'Projects/show/1';

        private $db;
        private $auth;

        private $uri;

        private $controller;
        private $action;
        private $params;

        function __construct() {
            $this->db   = new Database();
            $this->auth = new Auth($this->db);

            $this->getUri();
            $this->parseUri($this->uri);
            if(!$this->route()) {
                $this->parseUri($this->defaultParams);
                $this->route();
            };
        }

        private function getUri() {
            $this->uri = substr($_SERVER["REQUEST_URI"], strlen(dirname($_SERVER['SCRIPT_NAME'])));
            $this->uri = preg_replace('/[^a-zA-Z0-9-_\/]/', '', $this->uri);
        }

        private function parseUri($uri) {
            $uri                = explode('/', strtolower(trim($uri,'/')));
            $this->controller   = count($uri) ? ucfirst(array_shift($uri)) : '';
            $this->action       = count($uri) ? array_shift($uri) : '';
            $this->params       = count($uri) ? $uri : [];
        }

        private function route() {
            $controllerClass = 'Controllers\\'.$this->controller;

            if(!file_exists($controllerClass.'.php')) { return false; }
            $controller = new $controllerClass($this->db, $this->auth);

            if (!is_callable([$controller, $this->action])) { return false; }
            call_user_func_array([$controller, $this->action], [$this->params]);

            return true;
        }
    }

}?>