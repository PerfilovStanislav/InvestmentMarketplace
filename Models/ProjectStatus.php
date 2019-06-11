<?php

namespace Models {

    use Traits\Collection;

    class ProjectStatus {
        use Collection;

        CONST
            NOT_PUBLISHED = 1,
            ACTIVE = 2,
            PAYWAIT = 3,
            SCAM = 4;
    }
}
