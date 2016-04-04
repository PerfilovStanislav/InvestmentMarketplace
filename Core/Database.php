<?php

namespace Core {
	use \mysqli;

	class Database extends mysqli{
		private $db_host = 'localhost';
		private $db_user = 'test';
		private $db_pass = '';
		private $db_name = 'test';

		private $queries = [];
		private $errors = [];

		function __construct() {
			parent::__construct($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			if(!@mysqli_connect_errno()){
				$this->set_charset("utf8");
				$this->autocommit(false);
				$this->query("SET collation_connection = utf8_general_ci;");
				return true;
			}else{
				return false;
			}
		}

		public function add($sql) {
			$this->queries[] = $sql;
		}

		public function execute() {
			if ($this->errors) {
				$this->errors = [];
				$this->queries = [];
				return false;
			}

			$error = false;
			$this->begin_transaction();
			foreach ($this->queries as $query) {
				if (!$this->query($query)) {
					$error = true;
					break;
				}
			}
			$this->queries = [];
			if ($error) {
				$this->rollback();
				return false;
			}
			else {
				$this->commit();
				return true;
			}
		}

		public function getResult($sql) {
			return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
		}

		/**
		 * @param string $table
		 * @param string $fields
		 * @param string $where
		 * @param string $order
		 * @param string $limit
         * @return Database $this
         */
		public function select($table, $fields = '*', $where = null, $order = null, $limit = null) {
            $q = 'SELECT '.$fields.' FROM '.$table;
			if($where !== null){
                $q .= ' WHERE '.$where;
			}
			if($order !== null){
                $q .= ' ORDER BY '.$order;
			}
			if($limit !== null){
                $q .= ' LIMIT '.$limit;
			}
			return $this->getResult($q);
		}

		public function lastID($table) {
			$q = 'SELECT max(id) as id FROM '.$table;
			return $this->getResult($q)[0]['id'];
		}

		public function insert($table, array $params){
			if (empty($params)) $this->errors[] = -2;
			$this->add('INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES (' . implode(',', $this->makeQuotes($params)) . ')');
			return $this;
		}

		/**
		 * @param string $table
		 * @param array $fields
		 * @param array $data
		 * @return Database $this
         */
		public function multiInsert($table, array $fields, array $data){
			if (empty($data) || !is_array($data)) {
				$this->errors = -2;
				return $this;
			}

			// check count of values
			$cnt = count($data[0]);
			foreach($data as $k => $v) {
				if (!is_array($v) || count($v) !== $cnt) {
					$this->errors = -3;
					return $this;
				}
			}

			// Rotate array
			array_unshift($data, null);
			$data = call_user_func_array('array_map', $data);

			foreach($data as &$v) {
				$v = '(' . implode(',', $this->makeQuotes($v)) . ')';
			}

			$this->add('INSERT INTO `'.$table.'` (`'.implode('`,`',$fields).'`) VALUES'.implode(',', $data));
			return $this;
		}

		public function update($table, array $params, $where){
			$args=[];
			foreach($params as $field=>$value) {
				$args[] = $field.'="'.$value.'"';
			}
			$this->add('UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where);
			return $this;
		}

		/**
		 * Add quotes to values and
		 * Don't change declared variables
		 * @param array $ar
		 * @return array
		 */
		private function makeQuotes(array &$ar) {
			return array_map(
				function($a){
					return strpos($a, "@") === 0 ? $a : '"'.$a.'"';
				}, $ar
			);
		}
	}

}?>