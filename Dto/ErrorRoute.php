<?php

namespace Dto;

use Controllers\Errors;
use Helpers\Output;

class ErrorRoute extends AbstractRoute
{
    protected string $controllerClass = Errors::class;
    protected string $action = 'show';
    protected array  $params = [];

    public function __construct(string $title, string $description = '', int $code = 404) {
        Output()->addHeader(Output::E404);
        $this->params = [
            'title'       => $title,
            'description' => $description,
            'code'        => $code,
        ];
    }
}
