<?php

namespace Models {

    use Core\{Model, Database};

    class Main{
        public static $db;

        function __construct(Database $db) {
            self::$db = $db;
        }
    }
}