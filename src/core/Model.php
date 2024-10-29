<?php

namespace core;

class Model {
    protected $pdo;

    public function __construct() {
        $dsn = 'mysql:host=mysql_container;dbname=mydatabase';
        $user = 'myuser';
        $password = 'mypassword';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
}
