<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

ob_start(); // Inicia o buffer de saída
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-dashboard fa-fw"></i> Dashboard</li>
    </ol>
</nav>

<div class="row mt-5">
    <div class="col-md-3 text-center">
        <h1><?php echo $total_tarefas ?></h1>
        <span class="text-muted">Total de Tarefas</span>
    </div>
    <div class="col-md-3 text-center">
        <h1><?php echo $total_usuarios ?></h1>
        <span class="text-muted">Total de Usuários</span>
    </div>
</div>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Lista de Tarefas';
require __DIR__ . '/layouts/main.php'; // Inclui o layout mestre
