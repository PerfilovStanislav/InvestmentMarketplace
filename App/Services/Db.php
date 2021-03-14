<?php

namespace App\Services;

use App\Helpers\Sql;
use App\Traits\Instance;

class Db
{
    use Instance;

    /** @var resource */
    protected $dbConnection;
    private string $connectionParams;

    public function __construct()
    {
        $this->connectionParams = \sprintf("host=%s port=%d dbname=%s user=%s password=%s",
            \Config::DB_HOST,
            \Config::DB_PORT,
            \Config::DB_NAME,
            \Config::DB_USER,
            \Config::DB_PASS
        );
    }

    public function __destruct()
    {
        if (\is_resource($this->dbConnection)) {
            \pg_close($this->dbConnection);
        }
    }

    /** @return resource */
    protected function getConnection()
    {
        if (\is_resource($this->dbConnection)) {
            return $this->dbConnection;
        }
        return $this->dbConnection = \pg_connect($this->connectionParams);
    }

    protected function getResult(Sql $sql)
    {
        return \pg_query($this->getConnection(), (string)$sql);
    }

    /** @return array */
    public function exec(Sql $sql, array $mapFields = [])
    {
        $result = \pg_fetch_all($q = $this->getResult($sql));
        return $result !== false
            ? (empty($mapFields)
                ? $result
                : $this->mapping($q, $result, $mapFields)
            )
            : [];
    }

    /** @return array */
    public function execOne(Sql $sql, array $mapFields = [])
    {
        $result = \pg_fetch_assoc($q = $this->getResult($sql));
        return $result !== false
            ? (empty($mapFields)
                ? $result
                : $this->mapping($q, [$result], $mapFields)[0]
            )
            : [];
    }

    private function mapping($q, $result, array $mapFields)
    {
        $mapFields = \array_flip($mapFields);
        $types = [];
        for ($i = 0, $count = \pg_num_fields($q); $i < $count; ++$i) {
            $types[$i] = isset($mapFields[\pg_field_name($q, $i)])
                ? \pg_field_type_oid($q, $i)
                : null;
        }
        foreach ($result as &$row) {
            $i = -1;
            foreach ($row as &$value) {
                ++$i;
                if ($value === null || $types[$i] === null) {
                    continue;
                }
                $value = $this->transform($types[$i], $value, $q, $i);
            }
        }
        unset($value, $row);

        return $result;
    }

    private function transform(int $type, string $value, $q, int $i)
    {
        switch ($type) {
            case 20:
            case 21:
            case 23:    return (int)$value;
            case 16:    return $value === 't';
            case 3802:
            case 114:   return \json_decode($value, true);
            case 1007:  return \array_map('intval', \explode(',', \substr($value, 1, -1)));
            default:
                throw new \RuntimeException(
                    \pg_field_type($q, $i) .' type. Need mapping ' . \pg_field_type_oid($q, $i) . ' ' . $value
                );
        }
    }
}
