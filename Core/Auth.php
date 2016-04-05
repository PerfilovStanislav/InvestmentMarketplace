<?php

namespace Core;
#TODO Написать класс Auth
class Auth {
	private $db;
	public $isAuthorized = false;
    function __construct(Database $db) {
		$this->db = $db;
    }	
}

?>