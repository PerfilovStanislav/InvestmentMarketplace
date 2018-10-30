<?php

namespace Core;

class Model {
	public $db;
	
    protected function __construct() {
		$this->db = Database::getInstance();
    }
}
