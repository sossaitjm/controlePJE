<?php
// Define as rotas da aplicação (ação na URL => método na controller)
$routes = [
    'listar' => 'listar',
    'listarTabela' => 'listarDocumentosEmTabela'
];

// Função para retornar o método da controller com base na ação
function getRoute($acao) {
    global $routes;
    return $routes[$acao] ?? false;
}
