<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    public function listar() {
        $usuario = new Usuario();
        $dados = $usuario->buscarPorId(67342); // ID fixo para teste
        $qtdSemDtJuntada = $usuario->buscarDocumentosSemDataJuntada();
        $listaDocumentos = $usuario->listarDocumentosSemJuntada();

        include __DIR__ . '/../views/lista_usuarios.php';
    }

    // ✅ Nova função que exibe a tabela
    public function listarDocumentosEmTabela() {
        $usuario = new Usuario();
        $listaDocumentos = $usuario->listarDocumentosSemJuntada();

        // Passa os dados para a view chamada tables.php (ou .html se estática)
        include __DIR__ . '/../views/tables.php';
    }
}
