<?php

use Controllers\AuthController;
use Controllers\HomeController;
use Controllers\TarefaController;
use Controllers\UsuarioController;

return [
    'forgot-password' => [AuthController::class, 'forgotPassword'],
    'reset-password' => [AuthController::class, 'resetPassword'],
    'login' => [AuthController::class, 'login'],
    'logout' => [AuthController::class, 'logout'],
    '' => [HomeController::class, 'index'],
    'tarefas/index' => [TarefaController::class, 'index'],
    'tarefas/create' => [TarefaController::class, 'create'],
    'tarefas/edit/{id}' => [TarefaController::class, 'edit'],
    'tarefas/delete/{id}' => [TarefaController::class, 'delete'],
    'usuarios/index' => [UsuarioController::class, 'index'],
    'usuarios/create' => [UsuarioController::class, 'create'],
    'usuarios/edit/{id}' => [UsuarioController::class, 'edit'],
    'usuarios/delete/{id}' => [UsuarioController::class, 'delete'],
];
