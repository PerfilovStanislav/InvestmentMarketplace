<?php

namespace Models {

    use Core\{Model, Database};

    class Main extends Model{

        function __construct(Database $db) {
            parent::__construct($db);
        }

        public function getLanguages(Validator $post) {

        }
    }
}