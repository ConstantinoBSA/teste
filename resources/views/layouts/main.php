<?php
$config = require __DIR__ . '/../../../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app']['app_name'] ?? '[NOME_PROJETO]'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php __DIR__?>/assets/css/styles.css">
    <style>
        .html{
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <h5><?php echo $config['app']['app_name'] ?? '[NOME_PROJETO]'; ?></h5>
    <header>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/tarefas/index">Tarefas</a></li>
                <li><a href="/usuarios/index">Usuários</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <p>&copy; 2024 Meu Aplicativo</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
