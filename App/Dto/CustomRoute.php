<?php

namespace App\Dto;

class CustomRoute extends AbstractRoute
{
    protected string $controllerClass = '';
    protected string $action = '';
    protected array  $params = [];

    public function __construct(string $controllerClass, string $action, array $params = [])
    {
        $this->controllerClass = $controllerClass;
        $this->action = $action;
        $this->params = $params;
    }
}
