<?php

namespace Controllers;

use Core\Controller;

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel = $this->model('Usuario');
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $usuarioModel->getByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /');
                exit();
            } else {
                echo "Usuário ou senha inválidos.";
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
