<?php

namespace Controllers;

class TarefaController extends \core\Controller {
    public function index() {
        $tarefaModel = $this->model('Tarefa');
        $tarefas = $tarefaModel->getAll();
        $this->view('tarefas/index', ['tarefas' => $tarefas]);
    }
}
