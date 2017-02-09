<?php


namespace Core {
	use \PDO;
	use Helpers\Validator;

	class Database extends PDO{
		private $db_dns;
		private $db_name = 'HyipMonitoring';
		private $db_host = '127.0.0.1';
		private $db_port = '5432';
		private $db_user = 'postgres';
		private $db_pass = 'itsall4you';

		public $queries = [];
		public $errors = [];

		function __construct() {
			$this->db_dns = "pgsql:dbname={$this->db_name};host={$this->db_host};port={$this->db_port}";
			parent::__construct($this->db_dns, $this->db_user, $this->db_pass, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
		}

		public function insert($table, array $params) {
			if (empty($params)) return null;
			$table = Validator::replace(Validator::TABLENAME, $table);

			$head 			= array_keys($params);
			$columnNames 	= implode(',', $head);


			$values= [];
			$rows = count($params[$head[0]][0]);
			for($i=0; $i<$rows; $i++) {
				foreach ($params as $k => $v) {
					$values[$i][] = $v[0][$i];
				}
			}
			$columns = count($values[0]);
			$questions = implode(array_fill(0, $rows, '('.implode(array_fill(0, $columns, '?'), ',').')'), ',');


			$stmt = $this->prepare("INSERT INTO $table ($columnNames) VALUES $questions");
			$this->beginTransaction();
			foreach ($values as $a => $b) {
				foreach ($b as $k => $v) {
					$stmt->bindValue($a*$columns+$k+1, $v, $v === null ? PDO::PARAM_NULL : $this::PARAM_INT);
				}
			}
			$stmt->execute();

			if ($stmt->errorCode() === '00000') {
				$this->commit();
				return true;
			}
			else {
				$this->rollBack();
				var_dump($stmt->errorInfo());
				return false;
			}
		}

		public function updateOne($table, array $params, $where) {
			if (empty($params)) return null;
			$table = Validator::replace(Validator::TABLENAME, $table);

			$head 		= array_keys($params);
			foreach ($head as $k => &$v) {
				$v = substr($v,1)."=$v";
			}
			$bindValues = implode(',', $head);

			$stmt = $this->prepare("UPDATE $table set $bindValues where $where");
			$this->beginTransaction();

			foreach ($params as $k => $v) {
				if ($v === null) $stmt->bindValue($k, $v, PDO::PARAM_NULL);
				else $stmt->bindValue($k, $v);
			}
			$stmt->execute();

			if ($stmt->errorCode() === '00000') {
				$this->commit();
				return true;
			}
			else {
				$this->rollBack();
				var_dump($stmt->errorInfo());
				return false;
			}
		}

		public function deleteOne($table, $where = null) {
			if ($where === null) return null;
			$table = Validator::replace(Validator::TABLENAME, $table);

			$stmt = $this->prepare("DELETE from $table where $where");
			$this->beginTransaction();
			$stmt->execute();
			if ($stmt->errorCode() === '00000') {
				$this->commit();
				return true;
			}
			else {
				$this->rollBack();
				var_dump($stmt->errorInfo());
				return false;
			}
		}

		public function getResult($sql, $debug=false) {
			$res = $this->query($sql);
			if ($debug) var_dump($sql);
			return $res->fetchAll(PDO::FETCH_ASSOC) ?? null;
		}

		/**
		 * @param string $table
		 * @param string $fields
		 * @param string $where
		 * @param string $order
		 * @param string $limit
		 * @return Database $this
		 */
		public function select($table, $fields = '*', $where = null, $order = null, $limit = null, $offset = null) {
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
			if($offset !== null){
				$q .= ' offset '.$offset;
			}
			return $this->getResult($q);
		}

		public function debugselect($table, $fields = '*', $where = null, $order = null, $limit = null, $offset = null) {
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
			if($offset !== null){
				$q .= ' offset '.$offset;
			}
			var_dump($q);
			return $this->getResult($q);
		}

		public function getOne($table, $fields = '*', $where = null, $order = null) {
			$res = $this->select($table, $fields, $where, $order);
			return $res[0] ?? null;
		}

		public function getOneDebug($table, $fields = '*', $where = null, $order = null) {
			$res = $this->debugselect($table, $fields, $where, $order);
			return $res[0] ?? null;
		}

		/*public function getByClass() {
			$sth = $this->query("SELECT * FROM users");
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Classes\Person');
			$person = $sth->fetchAll();
			echo '<pre>';
			var_dump($person[0]->id); die();
		}*/

		public function lastID($table, $where = null) {
			$q = 'SELECT max(id) as id FROM '.$table;
			if($where !== null){
				$q .= ' WHERE '.$where;
			}
			return $this->getResult($q)[0]['id'] ?? null;
		}
	}

}
/*
namespace Core {
	use \mysqli;

	class Database extends mysqli{
		private $db_host = 'localhost';
		private $db_user = 'test';
		private $db_pass = '';
		private $db_name = 'test';

		public $queries = [];
		public $errors = [];

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
			$res = $this->query($sql);
			return $res ? $res->fetch_all(MYSQLI_ASSOC) : null;
		}

		/**
		 * @param string $table
		 * @param string $fields
		 * @param string $where
		 * @param string $order
		 * @param string $limit
         * @return Database $this
         */
		/*public function select($table, $fields = '*', $where = null, $order = null, $limit = null) {
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

		public function getOne($table, $fields = '*', $where = null, $order = null) {
			$res = $this->select($table, $fields, $where, $order);
			return count($res) > 0 ? $res[0] : false;
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
		/*public function multiInsert($table, array $fields, array $data){
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
		/*private function makeQuotes(array &$ar) {
			return array_map(
				function($a){
					return strpos($a, "@") === 0 ? $a : '"'.$a.'"';
				}, $ar
			);
		}
	}

}*/?>