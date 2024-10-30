<?php

namespace Models;

use Core\Model;

class Tarefa extends Model {
    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM tarefas');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tarefas WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($titulo, $descricao, $status)
    {
        $stmt = $this->pdo->prepare('INSERT INTO tarefas (titulo, descricao, status) VALUES (?, ?, ?)');
        return $stmt->execute([$titulo, $descricao, $status]);
    }

    public function update($id, $titulo, $descricao, $status)
    {
        $stmt = $this->pdo->prepare('UPDATE tarefas SET titulo = ?, descricao = ?, status = ? WHERE id = ?');
        return $stmt->execute([$titulo, $descricao, $status, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM tarefas WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
