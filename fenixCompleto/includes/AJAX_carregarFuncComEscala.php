<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

try {
    // Consulta para buscar funcionários em escala de trabalho
    $query = "SELECT f.id, f.nome FROM funcionarios f
    WHERE f.id IN (SELECT DISTINCT motorista_id FROM escalas) 
    OR f.id IN (SELECT DISTINCT cobrador_id FROM escalas)";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os veículos como JSON
    header("Content-Type: application/json");
    echo json_encode($funcionarios);
} catch (PDOException $e) {
    // Tratamento de erro para falhas na consulta
    echo "Erro na consulta: " . $e->getMessage();
}
?>
