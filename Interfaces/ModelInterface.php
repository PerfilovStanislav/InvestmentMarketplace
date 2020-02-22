<?php

namespace Interfaces;

use Core\Database;

interface ModelInterface
{
    public static function getDb(): Database;

    public function save();

    public function getRowFromDbAndFill(array $where);
}
