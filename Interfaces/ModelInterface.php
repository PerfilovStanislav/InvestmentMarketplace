<?php

namespace Interfaces;

use Core\Database;

interface ModelInterface
{
    public static function setTable(): Database;

    public function save();

    public function getRowFromDbAndFill(array $where);
}
