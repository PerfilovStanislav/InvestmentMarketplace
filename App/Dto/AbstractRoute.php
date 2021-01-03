<?php

namespace App\Dto;

class AbstractRoute implements RouteInterface
{
    protected string $controllerClass = '';
    protected string $action = '';
    protected array  $params = [];

    public function getControllerClass(): string {
        return $this->controllerClass;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function getParams(): array {
        return $this->params;
    }

    public function generateUrl(): string {
        return '/' . str_replace('App\Controllers\\', '', $this->controllerClass) . '/' . $this->action;
    }
}
