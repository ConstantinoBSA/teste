<?php

namespace Controllers;

use Core\Controller;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarioModel = $this->model('Usuario');
        $usuarios = $usuarioModel->getAll();
        $this->view('usuarios/index', ['usuarios' => $usuarios]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel = $this->model('Usuario');
            $usuarioModel->create($_POST['username']);
            header('Location: /usuarios/index');
        } else {
            $this->view('usuarios/create');
        }
    }

    public function edit($id)
    {
        $usuarioModel = $this->model('Usuario');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel->update($id, $_POST['username']);
            header('Location: /usuarios/index');
        } else {
            $usuario = $usuarioModel->getById($id);
            if ($usuario) {
                $this->view('usuarios/edit', ['usuario' => $usuario]);
            } else {
                $this->renderErrorPage('Erro 404', 'Usuário não encontrado.');
            }
        }
    }

    public function delete($id)
    {
        $usuarioModel = $this->model('Usuario');
        $usuarioModel->delete($id);
        header('Location: /usuarios/index');
    }

    // Função para renderizar a view de erro
    private function renderErrorPage($title, $message)
    {
        $errorTitle = $title;
        $errorMessage = $message;
        include 'views/error.php';
        exit();
    }
}
