<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefaModel = $this->model('Tarefa');
        $tarefas = $tarefaModel->getAll();
        $this->view('tarefas/index', ['tarefas' => $tarefas]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();
            $rules = [
                'titulo' => 'required',
                'descricao' => 'required',
                'status' => 'required'
            ];

            $errors = $validator->validate($_POST, $rules);

            if (!empty($errors)) {
                $this->view('tarefas/create', ['error' => $errors, 'data' => $_POST]);
            } else {
                $tarefaModel = $this->model('Tarefa');
                $tarefaModel->create($_POST['titulo'], $_POST['descricao'], $_POST['status']);
                header('Location: /tarefas/index');
                exit();
            }
        } else {
            $this->view('tarefas/create', ['error' => [], 'data' => []]);
        }
    }

    public function edit($id)
    {
        session_start();
        $tarefaModel = $this->model('Tarefa');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();
            $rules = [
                'titulo' => 'required',
                'descricao' => 'required',
                'status' => 'required'
            ];

            $errors = $validator->validate($_POST, $rules);

            if (!empty($errors)) {
                $data = array_merge($_POST, ['id' => $id]);
                $this->view('tarefas/edit', ['error' => $errors, 'data' => $data]);
            } else {
                $tarefa = $tarefaModel->update($id, $_POST['titulo'], $_POST['descricao'], $_POST['status']);
                if ($tarefa) {
                    $_SESSION['success_message'] = 'Tarefa editada com sucesso!';
                } else {
                    $_SESSION['error_message'] = 'Erro ao adicionar tarefa. Por favor, tente novamente!';
                }
                header('Location: /tarefas/index');
            }
        } else {
            $tarefa = $tarefaModel->getById($id);
            if ($tarefa) {
                $this->view('tarefas/edit', ['error' => [], 'data' => $tarefa]);
            } else {
                $this->renderErrorPage('Erro 404', 'Tarefa não encontrada.');
            }
        }
    }

    public function delete($id)
    {
        $tarefaModel = $this->model('Tarefa');
        $tarefaModel->delete($id);
        header('Location: /tarefas/index');
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