<?php
ob_start(); // Inicia o buffer de saída
?>

<h1>Editar Usuário</h1>
<a href="/usuarios/index">Voltar</a>
<form method="post" action="/usuarios/edit/<?php echo $data['usuario']['id']; ?>">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($data['usuario']['username']); ?>" required>
    <button type="submit">Salvar</button>
</form>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Editar Usuário';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
