<?php

namespace Core;

class Model
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }
}
