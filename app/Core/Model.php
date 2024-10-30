<?php

namespace Core;

require_once __DIR__ . '/../../config/constants.php';

class Model
{
    protected $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=mysql_container;dbname=mydatabase';
        $user = DB_USER;
        $password = DB_PASS;

        try {
            // Use a classe PDO global do PHP
            $this->pdo = new \PDO($dsn, $user, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
}
