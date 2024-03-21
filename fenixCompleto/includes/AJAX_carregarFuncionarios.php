<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

// Consulta para buscar funcionários e verificar se estão cadastrados em escalas
$query = "SELECT f.id, f.nome, f.matricula, IFNULL(e.em_escala, 0) AS em_escala
          FROM funcionarios f
          LEFT JOIN (
              SELECT motorista_id AS funcionario_id, 1 AS em_escala FROM escalas
              UNION ALL
              SELECT cobrador_id AS funcionario_id, 1 AS em_escala FROM escalas
          ) e ON f.id = e.funcionario_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define a cor com base na coluna "em_escala"
foreach ($funcionarios as &$funcionario) {
    $funcionario['cor'] = $funcionario['em_escala'] == 1 ? 'vermelho' : 'verde';
}

// Retorna os funcionários como JSON
header("Content-Type: application/json");
echo json_encode($funcionarios);
?>
