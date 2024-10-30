<?php
ob_start(); // Inicia o buffer de saída
?>

<h1>Criar Nova Tarefa</h1>
<a href="/tarefas/index">Voltar</a>

<form method="post" action="/tarefas/create">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($data['data']['titulo'] ?? ''); ?>">
        <?php if (!empty($data['errors']['titulo'])): ?>
            <p class="error"><?php echo htmlspecialchars($data['errors']['titulo']); ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea name="descricao" class="form-control" id="descricao"><?php echo htmlspecialchars($data['data']['descricao'] ?? ''); ?></textarea>
        <?php if (!empty($data['errors']['descricao'])): ?>
            <p class="error"><?php echo htmlspecialchars($data['errors']['descricao']); ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select" id="status">
            <option value="pendente" <?php if (($data['data']['status'] ?? '') === 'pendente') {
                echo 'selected';
            } ?>>Pendente</option>
            <option value="concluída" <?php if (($data['data']['status'] ?? '') === 'concluída') {
                echo 'selected';
            } ?>>Concluída</option>
        </select>
        <?php if (!empty($data['errors']['status'])): ?>
            <p class="error"><?php echo htmlspecialchars($data['errors']['status']); ?></p>
        <?php endif; ?>
    </div>

    <button class="btn btn-primary" type="submit">Criar Tarefa</button>
</form>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Adicionar Tarefa';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
