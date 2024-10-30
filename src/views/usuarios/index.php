<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

ob_start(); // Inicia o buffer de saída
?>

<h2>Lista de Usuários</h2>
<a href="/usuarios/create">Criar Novo Usuário</a>

<table class="table">
    <thead>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
    </thead>
    <tbody>
        <?php foreach ($data['usuarios'] as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                <td>
                    <a href="/usuarios/edit/<?php echo $usuario['id']; ?>">Editar</a>
                    <a href="/usuarios/delete/<?php echo $usuario['id']; ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Lista de Usuários';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
