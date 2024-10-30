<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

ob_start(); // Inicia o buffer de saída
?>

<h2>Lista de Tarefas</h2>
<a href="/tarefas/create">Criar Nova Tarefa</a>

<table class="table">
    <thead>
        <th>ID</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Status</th>
        <th>Ações</th>
    </thead>
    <tbody>
        <?php foreach ($data['tarefas'] as $tarefa): ?>
            <tr>
                <td><?php echo htmlspecialchars($tarefa['id']); ?></td>
                <td><?php echo htmlspecialchars($tarefa['titulo']); ?></td>
                <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
                <td><?php echo htmlspecialchars($tarefa['status']); ?></td>
                <td>
                    <a href="/tarefas/edit/<?php echo $tarefa['id']; ?>">Editar</a>
                    <a href="/tarefas/delete/<?php echo $tarefa['id']; ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Lista de Tarefas';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
