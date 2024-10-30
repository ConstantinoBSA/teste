<?php
require __DIR__ . '/../vendor/autoload.php';

// Função para carregar automaticamente classes do projeto
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/../app/';
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

// Função para renderizar a view de erro
function renderErrorPage($title, $message)
{
    $errorTitle = $title;
    $errorMessage = $message;
    include __DIR__ . '/../views/error.php';
    exit();
}

// Carregar as rotas
$routes = require __DIR__ . '/../routes/web.php';

// Obter a URL requisitada e remover a barra inicial
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

foreach ($routes as $route => $controllerAction) {
    // Converter a rota com parâmetros dinâmicos em uma expressão regular
    $routePattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\d+)', $route);
    $routePattern = str_replace('/', '\/', $routePattern);
    $routePattern = '/^' . $routePattern . '$/';

    // Verificar se a URL requisitada corresponde ao padrão da rota
    if (preg_match($routePattern, $request, $matches)) {
        list($controllerClass, $method) = $controllerAction;

        if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
            $controller = new $controllerClass();

            // Remover os índices numéricos do array de correspondências
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

            // Chamar o método do controlador com os parâmetros capturados
            call_user_func_array([$controller, $method], $params);
            exit;
        } else {
            renderErrorPage('Erro 404', 'Controlador ou método não encontrado.');
        }
    }
}

// Se nenhuma rota corresponder, retornar 404
renderErrorPage('Erro 404', 'Página não encontrada.');
