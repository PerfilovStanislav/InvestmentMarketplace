<?php

namespace App\Interfaces;

interface ModelInterface
{
    public static function setTable();

    public function save();

    public function getRowFromDbAndFill(array $where);
}
