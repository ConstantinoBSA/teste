<?php
ob_start(); // Inicia o buffer de saída
?>

<h1>Criar Novo Usuário</h1>
<a href="/usuarios/index">Voltar</a>
<form method="post" action="/usuarios/create">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>
    <button type="submit">Criar</button>
</form>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Adicionar Usuário';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
