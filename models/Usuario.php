<?php
require_once __DIR__ . '/../conexao.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    // Buscar usuário por ID
    public function buscarPorId($id) {
        $sql = "SELECT id_usuario FROM tb_usuario_login WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id_usuario'] : null;
    }

    // Contar documentos assinados sem data de juntada
    public function buscarDocumentosSemDataJuntada() {
        $sql = "SELECT COUNT(DISTINCT PD.id_processo_documento) AS qtd_processos_nao_juntados
                FROM tb_proc_doc_bin_pess_assin PDBPA
                INNER JOIN tb_processo_documento_bin PDB
                    ON PDBPA.id_processo_documento_bin = PDB.id_processo_documento_bin
                INNER JOIN tb_processo_documento PD
                    ON PDB.id_processo_documento_bin = PD.id_processo_documento_bin
                INNER JOIN tb_processo TP
                    ON TP.id_processo = PD.id_processo
                WHERE PD.dt_juntada IS NULL
                  AND PD.dt_exclusao IS NULL
                  AND TP.nr_processo IS NOT NULL";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['qtd_processos_nao_juntados'] : null;
    }

    // Listar documentos sem juntada (detalhes)
    public function listarDocumentosSemJuntada() {
        try {
            $sql = "SELECT DISTINCT 
                        PD.id_processo_documento,
                        PD.ds_processo_documento,
                        TP.nr_processo,
                        '1G' AS nr_instancia
                    FROM tb_proc_doc_bin_pess_assin PDBPA
                    INNER JOIN tb_processo_documento_bin PDB
                        ON PDBPA.id_processo_documento_bin = PDB.id_processo_documento_bin
                    INNER JOIN tb_processo_documento PD
                        ON PDB.id_processo_documento_bin = PD.id_processo_documento_bin
                    INNER JOIN tb_processo TP
                        ON TP.id_processo = PD.id_processo
                    WHERE PD.dt_juntada IS NULL
                      AND PD.dt_exclusao IS NULL
                      AND TP.nr_processo IS NOT NULL
                    ORDER BY TP.nr_processo, PD.id_processo_documento";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar documentos: " . $e->getMessage();
            return [];
        }
    }
}
