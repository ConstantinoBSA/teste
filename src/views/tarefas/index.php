<?php foreach ($data['tarefas'] as $tarefa): ?>
    <h2><?php echo htmlspecialchars($tarefa['titulo']); ?></h2>
    <p><?php echo htmlspecialchars($tarefa['descricao']); ?></p>
    <p>Status: <?php echo htmlspecialchars($tarefa['status']); ?></p>
<?php endforeach; ?>
