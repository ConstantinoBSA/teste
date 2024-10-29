<?php

namespace Controllers;

use Core\Controller;

class TarefaController extends Controller {
    public function index() {
        $tarefaModel = $this->model('Tarefa');
        $tarefas = $tarefaModel->getAll();
        $this->view('tarefas/index', ['tarefas' => $tarefas]);
    }
}
