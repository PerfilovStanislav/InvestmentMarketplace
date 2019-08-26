<?php

namespace Traits;

use Core\Database;

trait Model
{
    public static function getDb() : Database {
        return Database::getInstance()->setTable(self::$table);
    }

    public function save() : self {
        if ($this->id) {
            self::getDb()->updateById($this->id, $this->toDatabase());
        }
        else {
            $this->id = self::getDb()->insert($this->toDatabase());
        }
        return $this;
    }

    public function getRowFromDbAndFill(array $where) : self {
        $data = self::getDb()->selectRow($where);
        $this->fromArray($where + ($data ?? []));
        return $this;
    }

    public function getById(int $id) : self {
        return $this->getRowFromDbAndFill(['id' => $id]);
    }
}