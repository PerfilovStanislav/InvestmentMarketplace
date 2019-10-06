<?php

namespace Core;

use Helpers\{
    Output, Validator
};
use Mapping\StaticFilesRouteMapping;
use Traits\Instance;

class Router {
    use Instance;
    private $defaultParams = 'Investment/show',
            $errorParams   = 'Errors/show',
            $controller,
            $action,
            $params,
            $additional = [];

    private function __construct() {}

    public function startRoute() {
        if (!$this->action) {
            $this->setUri($this->defaultParams)->route();
        }
        else if (!$this->route()) {
            $this->setUri($this->errorParams)->route();
        }
    }

    private function getRequestUri() : string {
        return substr($_SERVER['REQUEST_URI'], strlen(DIR));
    }

    public function setUri(string $uri = null) : self {
        $uri                = $uri ?: $this->getRequestUri();
        $uri                = StaticFilesRouteMapping::get('/' . $uri) ?? $uri;
        $uri                = Validator::regex('uri', $uri, Validator::SITE_URI);
        $uri                = explode('/', strtolower(trim($uri,'/')));
        $this->controller   = count($uri) ? ucfirst(array_shift($uri)) : '';
        $this->action       = count($uri) ? array_shift($uri) : null;
        $this->params       = count($uri) ? $uri : [];
        return $this;
    }

    private function route() : bool {
        $controllerClass = 'Controllers\\'.$this->controller;

        if(!file_exists(real_path($controllerClass).'.php')) { return false; }
        $controller = new $controllerClass();

        if (!is_callable([$controller, $this->action])) { return false; }

        $params = array_filter(
            array_map(function(array $a){
                return $a[1]??false ? [$a[0] => $a[1]] : null;
            }, array_chunk($this->params, 2))
            , function($v) { return $v != null; }
        );

        $params = $params ? array_unique(call_user_func_array('array_merge', $params)) : [];
        $params += $_POST;
        $reflectionParameters = (new \ReflectionMethod($controller,  $this->action))->getParameters();
        if ($reflectionParameters) {
            $params = array_map(function (\ReflectionParameter $reflectionParameter) use (&$params) {
                if ($reflectionClass = $reflectionParameter->getClass()) {
                    $class = $reflectionClass->getName();
                    return new $class($params);
                }
                elseif ($param = ($params[$paramName = $reflectionParameter->getName()] ?? null)) {
                    return $param;
                }
                elseif ($reflectionParameter->isArray()) {
                    return $params;
                }
                elseif (($default = $reflectionParameter->getDefaultValue()) !== null) {
                    return $default;
                }
                return null;
            }, $reflectionParameters);
        }
        call_user_func_array([$controller, $this->action], $params);
        return Output::result();
    }

    public function getCurrentPageUrl() : string {
        return '/' . $this->controller . '/' . $this->action;
    }
}
