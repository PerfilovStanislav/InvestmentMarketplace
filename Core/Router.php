<?php

namespace Core {
    use Core\Database;
    use Core\Auth;
    use Libraries\Cleaner as Valid;

    class Router {
        private $defaultParams = 'Projects/show/1';

        private $db;
        private $auth;

        private $uri;

        private $controller;
        private $action;
        private $params;

        private $language;

        function __construct() {
            /*$this->db   = new Database();
            $this->auth = new Auth($this->db);

            $this->getUri();
            $this->parseUri($this->uri);
            if(!$this->route()) {
                $this->parseUri($this->defaultParams);
                $this->route();
            };*/


            echo '<pre>';
            $availableLanguages = ['en', 'ru', 'de'];
           if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
                if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                    $this->language = array_combine($list[1], $list[2]);
                    foreach ($this->language as $n => &$v)
                        $v = $v ? $v : 1;
                    arsort($this->language, SORT_NUMERIC);
                }
            } else $this->language = array();
//            $this->language = array_intersect(array_keys($this->language), $availableLanguages);
            print_r(array_keys($this->language)); die();

        }

        private function getUri() {
            $this->uri = substr($_SERVER["REQUEST_URI"], strlen(DIR));
            $this->uri = preg_replace('/[^a-zA-Z0-9-_\/]/', '', $this->uri);
            $this->uri = Valid::replace(Valid::URI, $this->uri);
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