<?php

namespace Controllers;

use Core\Controller;
use Core\Validator;
use App\Core\Sanitizer;

class TarefaController extends Controller
{
    protected $sanitizer;
    protected $validator;

    public function __construct()
    {
        $this->sanitizer = new Sanitizer();
        $this->validator = new Validator();
    }

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Token CSRF inválido.');
            }

            $sanitizedData = [
                'titulo' => $this->sanitizer->sanitizeString($_POST['titulo']),
                'descricao' => $this->sanitizer->sanitizeString($_POST['descricao']),
                'status' => $this->sanitizer->sanitizeString($_POST['status']),
            ];

            $rules = [
                'titulo' => 'required|unique:tarefas',
                'descricao' => 'required',
                'status' => 'required'
            ];

            $errors = $this->validator->validate($sanitizedData, $rules);

            if (!empty($errors)) {
                $this->view('tarefas/create', ['error' => $errors, 'data' => $sanitizedData]);
            } else {
                $tarefaModel = $this->model('Tarefa');
                $tarefa = $tarefaModel->create($sanitizedData['titulo'], $sanitizedData['descricao'], $sanitizedData['status']);
                if ($tarefa) {
                    $_SESSION['message'] = "Registro adicionaado com sucesso!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = 'Erro ao adicionar tarefa. Por favor, tente novamente!';
                    $_SESSION['message_type'] = "success";
                }

                // Token válido, remova-o da sessão
                unset($_SESSION['csrf_token']);

                header('Location: /tarefas/index');
            }
        } else {
            $this->view('tarefas/create', ['error' => [], 'data' => []]);
        }
    }

    public function edit($id)
    {
        $tarefaModel = $this->model('Tarefa');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Token CSRF inválido.');
            }

            $rules = [
                'titulo' => 'required',
                'descricao' => 'required',
                'status' => 'required'
            ];

            $errors = $this->validator->validate($_POST, $rules);

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

                // Token válido, remova-o da sessão
                unset($_SESSION['csrf_token']);

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
