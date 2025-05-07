<?php
// Carrega o controlador e as rotas
require_once 'controllers/UsuarioController.php';
require_once 'routes.php';  // Garante que o array de rotas está centralizado

// Instancia o controlador
$controller = new UsuarioController();

// Obtém a ação da URL (?acao=...)
$acao = $_GET['acao'] ?? 'listar';  // Valor padrão: listar

// Busca a função correspondente no array de rotas
$action = getRoute($acao);

if ($action) {
    // Chama o método da controller correspondente à ação
    $controller->$action();
} else {
    // Ação inválida ou rota não mapeada
    echo "Ação inválida!";
}
