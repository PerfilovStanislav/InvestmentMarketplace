<?php

namespace App\Dto;

use App\Controllers\Investment;

class DefaultRoute extends AbstractRoute
{
    protected string $controllerClass = Investment::class;
    protected string $action = 'show';
    protected array  $params = [];
}
