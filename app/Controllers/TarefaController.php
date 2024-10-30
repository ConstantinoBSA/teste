<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;

class TarefaController extends Controller
{
    public function index()
    {
        $search = $_GET['search'] ?? '';
        $page = $_GET['page'] ?? 1;
        $limit = 4; // Número de tarefas por página
        $offset = ($page - 1) * $limit;
        
        $tarefaModel = $this->model('Tarefa');
        $tarefas = $tarefaModel->getAll($search, $limit, $offset);
        $totalTarefas = $tarefaModel->countTarefas($search);
        $totalPages = ceil($totalTarefas / $limit);

        $start = $offset + 1;
        $end = min($offset + $limit, $totalTarefas);

        $this->view('tarefas/index', [
            'tarefas' => $tarefas,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'totalTarefas' => $totalTarefas,
            'start' => $start,
            'end' => $end,
            'search' => $search
        ]);
    }

    public function create()
    {
        session_start();
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
                $tarefa = $tarefaModel->create($_POST['titulo'], $_POST['descricao'], $_POST['status']);
                if ($tarefa) {
                    $_SESSION['message'] = "Registro adicionaado com sucesso!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = 'Erro ao adicionar tarefa. Por favor, tente novamente!';
                    $_SESSION['message_type'] = "success";
                }
                header('Location: /tarefas/index');
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
                    $_SESSION['message'] = "Registro editado com sucesso!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = 'Erro ao editar tarefa. Por favor, tente novamente!';
                    $_SESSION['message_type'] = "success";
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
        session_start();
        $tarefaModel = $this->model('Tarefa');
        $tarefa = $tarefaModel->delete($id);
        if ($tarefa) {
            $_SESSION['message'] = "Registro deletado com sucesso!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = 'Erro ao editar deletar. Por favor, tente novamente!';
            $_SESSION['message_type'] = "success";
        }
        header('Location: /tarefas/index');
    }

    // Função para renderizar a view de erro
    private function renderErrorPage($title, $message)
    {
        $errorTitle = $title;
        $errorMessage = $message;
        include '../resources/views/error.php';
        exit();
    }
}
