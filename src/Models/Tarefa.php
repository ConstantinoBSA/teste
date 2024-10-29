<?php

namespace Models;

use Core\Model;

class Tarefa extends Model {
    public function getAll() {
        $stmt = $this->pdo->query('SELECT * FROM tarefas');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
