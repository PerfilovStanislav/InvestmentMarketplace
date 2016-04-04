<?php

namespace Core;

class Model {
	public $db;
	
    function __construct(Database $db) {
		$this->db = $db;
    }
}

?>