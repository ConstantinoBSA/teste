<?php
require_once __DIR__ . '/../config/constants.php';

return [
    'database' => [
        'host' => DB_HOST,
        'user' => DB_USER,
        'pass' => DB_PASS,
        'name' => 'mydatabase',
    ],
    'app' => [
        'app_name' => 'Testando o PHP',
        'base_url' => 'http://localhost:8080',
    ],
];
