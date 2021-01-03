<?php

namespace App\Helpers;

use App\Exceptions\ErrorException;
use App\Traits\Instance;

class Errors
{
    use Instance;

    private bool $hasError = false;

    public function add($key, string $description, bool $exit = false): void {
        $this->hasError = true;
        Output()->addFieldDanger($key, $description);
        if ($exit) {
            throw new ErrorException($key, $description, 412);
        }
    }

    public function hasError(): bool {
        return $this->hasError;
    }

    public function exitIfExists(): void {
        if ($this->hasError()) {
            throw new ErrorException(Translate()->error, '', 412);
        }
    }
}
