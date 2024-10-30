<?php

namespace Models;

use Core\Model;

class Usuario extends Model
{
    public function getByUsername($username)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE username = ?');
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM usuarios');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($username)
    {
        $password = password_hash('123', PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare('INSERT INTO usuarios (username, password) VALUES (?, ?)');
        return $stmt->execute([$username, $password]);
    }

    public function update($id, $username)
    {
        $stmt = $this->pdo->prepare('UPDATE usuarios SET username = ? WHERE id = ?');
        return $stmt->execute([$username, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
