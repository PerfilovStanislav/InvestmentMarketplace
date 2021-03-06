<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class ProjectStatus implements ConstantInterface {
    use Collection;

    public const
        ACTIVE        = 1,
        PAYWAIT       = 2,
        NOT_PUBLISHED = 3,
        SCAM          = 4,
        DELETED       = 5;
}
