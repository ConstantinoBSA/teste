<?php
ob_start(); // Inicia o buffer de saída
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>/tarefas/index">Tarefas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
  </ol>
</nav>

<h4 class="mb-4">Editando Tarefa</h4>

<form method="post" action="/tarefas/edit/<?php echo $data['id']; ?>" class="w-50">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
    
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($data['titulo'] ?? ''); ?>">
        <?php if (!empty($error['titulo'])): ?>
            <p class="error"><?php echo htmlspecialchars($error['titulo']); ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea name="descricao" class="form-control" id="descricao"><?php echo htmlspecialchars($data['descricao'] ?? ''); ?></textarea>
        <?php if (!empty($error['descricao'])): ?>
            <p class="error"><?php echo htmlspecialchars($error['descricao']); ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select" id="status">
            <option value="pendente" <?php if (($data['status'] ?? '') === 'pendente') {
                echo 'selected';
            } ?>>Pendente</option>
            <option value="concluída" <?php if (($data['status'] ?? '') === 'concluída') {
                echo 'selected';
            } ?>>Concluída</option>
        </select>
        <?php if (!empty($error['status'])): ?>
            <p class="error"><?php echo htmlspecialchars($error['status']); ?></p>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <button class="btn btn-primary" type="submit"><i class="fa fa-check fa-fw"></i> Salvar Alterações</button>
        <span class="mx-1">|</span>
        <a  class="btn btn-secondary" href="/tarefas/index"><i class="fa fa-arrow-left fa-fw"></i> Voltar</a>
    </div>    
</form>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Editar Tarefa';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
