<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

try {
    // Consulta para buscar veículos em escala de trabalho com base no ID do veículo
    $query = "SELECT v.id, v.numero FROM veiculos v
              WHERE v.id IN (SELECT DISTINCT veiculo_id FROM escalas)";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os veículos como JSON
    header("Content-Type: application/json");
    echo json_encode($veiculos);
} catch (PDOException $e) {
    // Tratamento de erro para falhas na consulta
    echo "Erro na consulta: " . $e->getMessage();
}
?>
