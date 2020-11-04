<?php

namespace Traits;

use Core\Database;

trait Model
{
    public static function setTable() : Database {
        return Db()->setTable(self::$table);
    }

    public function save() : self {
        if ($this->id) {
            self::setTable()->updateById($this->id, $this->toDatabase());
        }
        else {
            $this->id = self::setTable()->insert($this->toDatabase());
        }
        return $this;
    }

    public function getRowFromDbAndFill(array $where, $fields = '*', $order = null) {
        $data = self::setTable()->selectRow($where, $fields, $order);
        return $this->fromArray($where + ($data ?? []));
    }

    public function getById(int $id) : self {
        return $this->getRowFromDbAndFill(['id' => $id]);
    }
}