<?php

namespace Interfaces;

use Core\Database;

interface ModelInterface
{
    static function getDb() : Database;

    function save();

    function getRowFromDbAndFill(array $where);
}
