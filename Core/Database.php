<?php
namespace Core {

    use Helpers\Output;
    use Helpers\PDOHelper;
    use Traits\Instance;
    use PDO;
    use PDOStatement;

    class Database extends PDO {

        use Instance;

        private
            $db_name = 'richinme',
            $db_host = 'richinme.com',
            $db_port = '5430',
            $db_user = 'globalpguser2',
            $db_pass = 'Itsall4you&me';

        private $table = null;

        private function __construct() {
            $db_dns = "pgsql:dbname={$this->db_name};host={$this->db_host};port={$this->db_port}";
            $opt = [
                self::ATTR_ERRMODE => self::ERRMODE_EXCEPTION,
                self::ATTR_DEFAULT_FETCH_MODE => self::FETCH_ASSOC,
                self::ATTR_EMULATE_PREPARES => false,
            ];
            parent::__construct($db_dns, $this->db_user, $this->db_pass, $opt);
        }

        public function setTable(string $table): self {
            $this->table = $table;
            return $this;
        }

        /**
         * @param null $where
         * @param string|array $fields
         * @param string|null $order
         * @param int|null $limit
         * @param int|null $offset
         * @return array
         */
        public function select($where = null, $fields = '*', string $order = null, int $limit = null, int $offset = null) {
            if (is_array($fields)) {
                /** @var array $fields */
                $fields = implode(',', $fields);
            }
            $sql = "SELECT {$fields} FROM {$this->table}";
            if ($where) {
                $sql .= $this->prepareWhere($where);
            }
            if($order !== null){
                $sql .= ' ORDER BY '.$order;
            }
            if($limit !== null){
                $sql .= ' LIMIT '.$limit;
            }
            if($offset !== null){
                $sql .= ' OFFSET '.$offset;
            }
            $stmt = $this->prepare($sql);
            if (is_array($where)) {
                $this->bindWhere($where, $stmt);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function selectRow($where, $fields = '*', $order = null) : ?array {
            return $this->select($where, $fields, $order, 1)[0] ?? null;
        }

        public function selectField($where, $field = 'id', $order = null) {
            return $this->selectRow($where, $field, $order)[$field] ?? null;
        }

        public function selectById(int $id, string $fields = '*'): ?array {
            return $this->selectRow(['id' => $id], $fields) ?? null;
        }

        public function insert(array $data): int {
            $sql = "INSERT INTO {$this->table} ({$this->prepareValues($data)}) VALUES ({$this->prepareValues($data, true)})";
            $stmt = $this->prepare($sql);
            $this->bindUpdate($data, $stmt);
            return $this->execute($stmt, true);
        }

        public function update($data, $where): int {
            $sql = "UPDATE {$this->table} SET " . $this->prepareUpdate($data);
            $sql .= $this->prepareWhere($where);
            $stmt = $this->prepare($sql);
            $this->bindWhere($where, $stmt)->bindUpdate($data, $stmt);
            return $this->execute($stmt);
        }

        public function updateById(int $id, array $data): int {
            return $this->update($data, ['id' => $id]);
        }

        public function delete($where): int {
            $sql = "DELETE FROM {$this->table}";
            $sql .= $this->prepareWhere($where);
            $stmt = $this->prepare($sql);
            $this->bindWhere($where, $stmt);
            return $this->execute($stmt);
        }

        private function execute(PDOStatement $stmt, bool $isInsert = false) : int {
            $this->beginTransaction();
            if ($stmt->execute() && $stmt->errorCode() === '00000') {
                $this->commit();
                return $isInsert ? $this->lastInsertId() : $stmt->rowCount();
            }
            else {
                $this->outputError($stmt);
                return 0;
            }
        }

        public function deleteById(int $id): int {
            return $this->delete(['id' => $id]);
        }

        private function prepareWhere($attributes): string {
            $sql = '';
            if ($attributes) {
                $sql .= ' WHERE ';
                if (is_string($attributes)) {
                    $sql .= $attributes;
                } elseif (is_array($attributes)) {
                    $columns = [];
                    foreach ($attributes as $k => $val) {
                        if (is_array($val)) {
                            $temp = implode(',', array_map(function($v) use ($k) {
                                return ':' . PDOHelper::prepareVal($k, $v);
                            } , $val));
                            $columns[] = "$k in ($temp)";
                        } else {
                            $columns[] = "$k = :" . PDOHelper::prepareVal($k, $val);
                        }
                    }
                    $sql .= implode(' and ', $columns);
                }
            }
            return $sql;
        }


        private function bindWhere(array $attributes, PDOStatement $stmt): self {
            foreach ($attributes as $k => $val) {
                $val = (array)$val;
                if (is_array($val)) {
                    foreach ($val as $v) {
                        $stmt->bindValue(':' . PDOHelper::prepareVal($k, $v), $v);
                    }
                }
            }
            return $this;
        }

        private function bindUpdate(array $attributes, PDOStatement $stmt): self {
            foreach ($attributes as $k => $val) {
                if (is_bool($val)) {
                    if ($val) $val = 'true';
                    else $val = 'false';
                }
                $stmt->bindValue(":{$k}", $val);
            }
            return $this;
        }

        private function prepareValues(array $data, bool $isValue = false): string {
            return implode(',', array_map(function($key) use ($isValue) {
                return ($isValue ? ':' : '') . $key;
            }, array_keys($data)));
        }

        private function prepareUpdate(array $data): string {
            return implode(',', array_map(function($key) {
                return "$key=:$key";
            }, array_keys($data)));
        }

        public function rawSelect(string $sql) {
            $stmt = $this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function refresh() {
            $sql = "REFRESH MATERIALIZED VIEW CONCURRENTLY {$this->table}";
            $stmt = $this->prepare($sql);
            return $stmt->execute();
        }

        private function outputError(PDOStatement $stmt) {
            $this->rollBack();
            Output::header(Output::E500);
            Output::addAlertDanger('query error', json_encode($stmt->errorInfo()));
        }
    }
}
