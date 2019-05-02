<?php

namespace Core {
	use \PDO;
	use Helpers\{Validator, Helper};
    use Traits\Instance;

    class Database extends PDO{
	    use Instance;

		private $db_dns,
		        $db_name = 'HyipMonitoring',
		        $db_host = '127.0.0.1',
		        $db_port = '5432',
		        $db_user = 'postgres',
		        $db_pass = 'itsall4you';

		public  $queries = [],
		        $errors = [];

        private static $_instance = null;

		function __construct() {
			$this->db_dns = "pgsql:dbname={$this->db_name};host={$this->db_host};port={$this->db_port}";
            parent::__construct($this->db_dns
                , $this->db_user
                , $this->db_pass
                , [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
		}

		public function insert($table, array $params) {
			if (empty($params)) return null;
			$table = Validator::replace(Validator::TABLENAME, $table);

			$head 			= array_keys($params);
			$columnNames 	= implode(',', $head);

			$values= [];
			$rows = count($params[$head[0]][0]);
			for($i=0; $i<$rows; $i++) {
				foreach ($params as $v) {
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
				Helper::header(Helper::E500);
                Helper::json(['error' => $stmt->errorInfo()]);
				return false;
			}
		}

		public function update(string $table, array $params, $where) {
			if (empty($params)) return null;
			$table = Validator::replace(Validator::TABLENAME, $table);

			$head 		= array_keys($params);
			foreach ($head as $k => &$v) {
				$v = substr($v,1)."=$v";
			}
			unset($v);
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
                Helper::header(Helper::E500);
                Helper::json(['error' => $stmt->errorInfo()]);
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
                Helper::header(Helper::E500);
                Helper::json(['error' => $stmt->errorInfo()]);
				return false;
			}
		}

		public function getResult($sql, $debug=false) {
			$res = $this->query($sql);
			if ($debug) var_dump($sql);
			if (!$res) return null;
			return $res->fetchAll(PDO::FETCH_ASSOC) ?? null;
		}

		/**
		 * @param $table
		 * @param string $fields
		 * @param null $where
		 * @param null $order
		 * @param null $limit
		 * @param null $offset
		 * @return array|null
		 */
		public function select($table, $fields = '*', $where = null, $order = null, $limit = null, $offset = null) {
			$q = 'SELECT '.$fields.' FROM '.$table;
			if($where !== null) {
				$q .= ' WHERE ';
				if (is_array($where)) {
					$tmp = [];
					foreach ($where as $key => $val) {
						if (is_array($val)) $tmp[] = sprintf('%s in (%s)', $key, implode(',', $val));
						else $tmp[] = sprintf("%s = '%s'", $key, $val);
					}
					$q .= implode(' AND ', $tmp);
				}
				else $q .= $where;
			}
			if($order !== null) {
				$q .= ' ORDER BY '.$order;
			}
			if($limit !== null) {
				$q .= ' LIMIT '.$limit;
			}
			if($offset !== null) {
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

		public function getRow($table, $fields = '*', $where = null, $order = null) {
			$res = $this->select($table, $fields, $where, $order, 1);
			return $res[0] ?? null;
		}

		public function getOne($table, $where = null, $field = 'id', $order = null) {
			$res = $this->getRow($table, $field, $where, $order);
			return $res[$field] ?? null;
		}

        public function getOneDebug($table, $where = null, $field = 'id', $order = null) {
            $res = $this->getRowDebug($table, $field, $where, $order);
            return $res[0] ?? null;
        }
        public function getRowDebug($table, $fields = '*', $where = null, $order = null) {
            $res = $this->debugselect($table, $fields, $where, $order, 1);
            return $res[0] ?? null;
        }

		public function lastID($table, $where = null) {
			$q = 'SELECT max(id) as id FROM '.$table;
			if($where !== null){
				$q .= ' WHERE '.$where;
			}
			return $this->getResult($q)[0]['id'] ?? null;
		}
	}
}