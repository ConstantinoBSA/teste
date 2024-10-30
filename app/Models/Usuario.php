<?php

namespace Models;

use Core\Model;

class Usuario extends Model
{
    public function getByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function storeResetToken($email, $token)
    {
        // Verifica se já existe um registro para este e-mail
        $sql = "SELECT * FROM password_resets WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $existingToken = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($existingToken) {
            // Atualiza o token e o timestamp se já existir um registro
            $sql = "UPDATE password_resets SET token = :token, created_at = NOW() WHERE email = :email";
        } else {
            // Insere um novo registro se não existir
            $sql = "INSERT INTO password_resets (email, token, created_at) VALUES (:email, :token, NOW())";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function findEmailByToken($token)
    {
        $sql = "SELECT email FROM password_resets WHERE token = :token LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['email'] : false;
    }

    public function updatePassword($email, $newPassword)
    {
        $sql = "UPDATE usuarios SET password = :password WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':password', $newPassword, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function invalidateToken($token)
    {
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
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
