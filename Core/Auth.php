<?php

namespace Core;
#TODO Написать класс Auth
class Auth {
	private $db;
	public $isAuthorized = true;
    function __construct(Database $db) {
		$this->db = $db;
    }	
}

?>