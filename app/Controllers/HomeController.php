<?php

namespace Controllers;

use Core\Controller;
use Models\Tarefa;
use Models\Usuario;

class HomeController extends Controller
{
    public function index()
    {
        $tarefa = new Tarefa();
        $total_tarefas = $tarefa->countTarefas();

        $usuario = new Usuario();
        $total_usuarios = $usuario->countUsuarios();

        $this->view('home', [
            'total_tarefas' => $total_tarefas,
            'total_usuarios' => $total_usuarios
        ]);
    }
}
