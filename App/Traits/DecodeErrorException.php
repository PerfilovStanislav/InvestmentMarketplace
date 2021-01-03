<?php

namespace App\Traits;

use App\Exceptions\ErrorException;

trait DecodeErrorException
{
    public function try(callable $functionForCall)
    {
        try {
            return $functionForCall();
        } catch (ErrorException $e) {
            Error()->add($e->getKey(), $e->getMessage());
        }
    }
}