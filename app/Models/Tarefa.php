<?php

namespace Models;

use Core\Model;

class Tarefa extends Model
{
    public function getAll($search = '', $limit = 10, $offset = 0)
    {
        $sql = "SELECT * FROM tarefas";
        $params = [];
    
        if ($search) {
            $sql .= " WHERE titulo LIKE :search OR descricao LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        $sql .= " ORDER BY titulo ASC";
    
        $sql .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = (int) $limit;
        $params[':offset'] = (int) $offset;
    
        $stmt = $this->pdo->prepare($sql);
    
        // Vincula os parâmetros
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
    
        $stmt->execute();
        $tarefas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Sanitiza os dados
        return array_map(function($tarefa) {
            return [
                'id' => htmlspecialchars($tarefa['id'], ENT_QUOTES, 'UTF-8'),
                'titulo' => htmlspecialchars($tarefa['titulo'], ENT_QUOTES, 'UTF-8'),
                'descricao' => htmlspecialchars($tarefa['descricao'], ENT_QUOTES, 'UTF-8'),
                'status' => htmlspecialchars($tarefa['status'], ENT_QUOTES, 'UTF-8'),
            ];
        }, $tarefas);
    }

    public function countTarefas($search = '')
    {
        $sql = "SELECT COUNT(*) FROM tarefas";
        $params = [];

        if ($search) {
            $sql .= " WHERE titulo LIKE :search OR descricao LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        $stmt = $this->pdo->prepare($sql);

        if (!empty($params)) {
            $stmt->bindValue(':search', $params[':search'], \PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchColumn();
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
