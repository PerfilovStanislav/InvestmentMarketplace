<?php

namespace Exceptions;

use Throwable;

class ErrorException extends \RuntimeException
{
    private string $key;

    public function __construct(string $key = '', $message = '', $code = 0, Throwable $previous = null) {
        $this->key = $key;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    final public function getKey(): string {
        return $this->key;
    }

}
