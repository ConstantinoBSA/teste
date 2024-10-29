<?php

namespace Models;

class Tarefa extends \core\Model {
    public function getAll() {
        $stmt = $this->pdo->query('SELECT * FROM tarefas');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Outros métodos como adicionar, atualizar e deletar tarefas podem ser adicionados aqui.
}
