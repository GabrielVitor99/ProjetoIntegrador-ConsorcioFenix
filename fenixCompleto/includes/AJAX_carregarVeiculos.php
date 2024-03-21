<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

try {
    // Consulta para buscar veículos e definir a cor com base no tipo_id
    $query = "SELECT id, numero, tipo_id FROM veiculos";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Define a cor com base no tipo_id
    foreach ($veiculos as &$veiculo) {
        switch ($veiculo['tipo_id']) {
            case 1:
                $veiculo['cor'] = 'azul';
                break;
            case 2:
                $veiculo['cor'] = 'amarelo';
                break;
            case 3:
                $veiculo['cor'] = 'roxo';
                break;
            default:
                $veiculo['cor'] = ''; // Outros tipos podem não ter uma cor específica
        }
    }

    // Retorna os veículos como JSON
    header("Content-Type: application/json");
    echo json_encode($veiculos);
} catch (PDOException $e) {
    // Tratamento de erro para falhas na consulta
    echo "Erro na consulta: " . $e->getMessage();
}
?>
