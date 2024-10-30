<?php
ob_start(); // Inicia o buffer de saída
?>

<h1>Editar Usuário</h1>
<a href="/usuarios/index">Voltar</a>

<form method="post" action="/usuarios/edit/<?php echo $data['id']; ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Título</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($data['name'] ?? ''); ?>">
        <?php if (!empty($error['name'])): ?>
            <p class="error"><?php echo htmlspecialchars($error['name']); ?></p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Título</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>">
        <?php if (!empty($error['email'])): ?>
            <p class="error"><?php echo htmlspecialchars($error['email']); ?></p>
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

    <button class="btn btn-primary" type="submit">Salvar Alterações</button>
</form>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Editar Usuário';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
