<?php

spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    $file = str_replace('controllers', 'Controllers', $file);
    $file = str_replace('models', 'Models', $file);
    $file = str_replace('core', 'Core', $file);

    if (file_exists($file)) {
        require $file;
    } else {
        echo "File not found: $file"; // Debug
    }
});

use Controllers\TarefaController;

$controller = new TarefaController();
$controller->index();
