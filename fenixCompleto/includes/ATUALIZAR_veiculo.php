<?php
require "conexaoBanco.php";

// Obtendo os valores do formulário
$veiculo_id = strip_tags($_POST['veiculo_id']);
$capacidade = strip_tags($_POST['capacidade']);
$tipo = strip_tags($_POST['tipo_id']);
$manterNumero = isset($_POST['manter_numero']);

// Verificar se uma das caixas está vazia
$requiredFields = array('tipo_id', 'capacidade');
$missingFields = array_filter($requiredFields, function($field) {
    return empty($_POST[$field]);
});

if (!empty($missingFields)) {
    $missingFieldsList = implode(', ', $missingFields);
    echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
} else {
    try {
        // Verificar se o número do veículo já existe (exceto se estiver editando o mesmo número ou mantendo o mesmo número)
        if (!$manterNumero) {
            $numero = strip_tags($_POST['numero']);
            $sql = $pdo->prepare("SELECT id FROM veiculos WHERE numero = ? AND (id != ? OR numero = ?)");
            $sql->execute(array($numero, $veiculo_id, $numero));
            $existingVehicle = $sql->fetch();

            if ($existingVehicle) {
                echo '<script>alert("Número de veículo já existe. Por favor, escolha outro número.")</script>';
                echo '<script>window.location.href = "../visual/opVeiculos.php";</script>';
            }
        }

        // Atualizar no banco de dados
        $sql = $pdo->prepare("UPDATE veiculos SET tipo_id = ?, " . ($manterNumero ? "" : "numero = ?,") . " capacidade = ? WHERE id = ?");
        $params = $manterNumero ? array($tipo, $capacidade, $veiculo_id) : array($tipo, $numero, $capacidade, $veiculo_id);

        if ($sql->execute($params)) {
            echo '<script>alert("Veículo atualizado com sucesso!")</script>';
        } else {
            echo '<script>alert("Erro ao atualizar, verifique se todos os campos foram preenchidos")</script>';
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    echo '<script>window.location.href = "../visual/opVeiculos.php";</script>';
}
?>
