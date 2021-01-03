<?php

namespace App\Traits;

trait Model
{
    /** @return \App\Core\Database */
    public static function setTable() {
        return Db()->setTable(self::$table);
    }

    /** @return static */
    public function save(): self {
        if ($this->id) {
            self::setTable()->updateById($this->id, $this->toDatabase());
        }
        else {
            $this->id = self::setTable()->insert($this->toDatabase());
        }
        return $this;
    }

    /** @return static */
    public function getRowFromDbAndFill(array $where, $fields = '*', $order = null) {
        $data = self::setTable()->selectRow($where, $fields, $order);
        return $this->fromArray($where + ($data ?? []));
    }

    /** @return static */
    public function getById(int $id) {
        return $this->getRowFromDbAndFill(['id' => $id]);
    }
}