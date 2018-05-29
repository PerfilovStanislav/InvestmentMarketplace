<?php

namespace  {

    class R {
        function __construct() {

        }

        public static final function r($data) {
            echo '<pre>';
            print_r($data);
            die();
        }
    }

}