<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

ob_start(); // Inicia o buffer de saída
?>

<h2>Tela Inicial</h2>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Lista de Tarefas';
require __DIR__ . '/layouts/main.php'; // Inclui o layout mestre
