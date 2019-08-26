<?php

namespace Models\Constant {

    use Interfaces\ConstantInterface;
    use Traits\Collection;

    class ProjectStatus implements ConstantInterface {
        use Collection;

        CONST
            ACTIVE        = 1,
            PAYWAIT       = 2,
            NOT_PUBLISHED = 3,
            SCAM          = 4;
    }
}
