<?php

namespace Helpers;

use Exceptions\ErrorException;
use Traits\Instance;

class Errors
{
    use Instance;

    private bool $hasError = false;

    public function add($key, string $description, bool $exit = false) {
        $this->hasError = true;
        Output()->addFieldDanger($key, $description);
        if ($exit) {
            throw new ErrorException($key, $description, 412);
        }
    }

    public function hasError(): bool {
        return $this->hasError;
    }

    public function exitIfExists() {
        if ($this->hasError()) {
            throw new ErrorException(Translate()->error, '', 412);
        }
    }
}
