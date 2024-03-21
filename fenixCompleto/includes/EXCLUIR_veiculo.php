<?php
require "conexaoBanco.php";

// Excluir um veículo
if (isset($_POST['excluirVeiculo'])) {
    // Obtendo o ID do veículo a ser excluído
    $veiculo_id = isset($_POST['veiculo_id_excluir']) ? strip_tags($_POST['veiculo_id_excluir']) : null;

    try {
        // Verificar se o veículo está vinculado a alguma escala
        $sqlEscala = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE veiculo_id = ?");
        $sqlEscala->execute([$veiculo_id]);
        $numEscalas = $sqlEscala->fetchColumn();

        if ($numEscalas > 0) {
            echo '<script>alert("Não é possível excluir o veículo, pois está vinculado a ' . $numEscalas . ' escalas.");</script>';
            // Redirecionar de volta para a página de onde veio ou qualquer outra página desejada
            echo '<script>window.location.href = "../visual/opVeiculos.php";</script>';
        } else {
            // Excluir o veículo se não estiver vinculado a nenhuma escala
            $sqlExcluir = $pdo->prepare("DELETE FROM veiculos WHERE id = ?");

            if ($sqlExcluir->execute([$veiculo_id])) {
                echo '<script>alert("Veículo excluído com sucesso!");</script>';
            } else {
                echo '<script>alert("Erro ao excluir o veículo.");</script>';
            }
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

// Redirecionar de volta para a página de onde veio ou qualquer outra página desejada
echo '<script>window.location.href = "../visual/opVeiculos.php";</script>';
}

?>