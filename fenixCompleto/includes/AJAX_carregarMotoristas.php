<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

try {
    // Consulta para buscar motoristas e verificar se estão cadastrados em escalas
    $query = "SELECT f.id, f.nome, f.matricula, IFNULL(e.em_escala, 0) AS em_escala
              FROM funcionarios f
              LEFT JOIN (
                  SELECT motorista_id AS funcionario_id, 1 AS em_escala FROM escalas
                  UNION ALL
                  SELECT cobrador_id AS funcionario_id, 1 AS em_escala FROM escalas
              ) e ON f.id = e.funcionario_id
              WHERE cargo_id = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $motoristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Define a cor com base na coluna "em_escala"
    foreach ($motoristas as &$motorista) {
        $motorista['cor'] = $motorista['em_escala'] == 1 ? 'vermelho' : 'verde';
    }

    // Retorna os motoristas como JSON
    header("Content-Type: application/json");
    echo json_encode($motoristas);
} catch (PDOException $e) {
    // Tratamento de erro para falhas na consulta
    echo "Erro na consulta: " . $e->getMessage();
}
?>
