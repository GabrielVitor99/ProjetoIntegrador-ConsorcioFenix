<?php
require "conexaoBanco.php";

// Excluir um funcionário
if (isset($_POST['excluirFuncionario'])) {
    // Obtendo o ID do funcionário a ser excluído
    $funcionario_id = isset($_POST['funcionario_id_excluir']) ? strip_tags($_POST['funcionario_id_excluir']) : null;

    try {
    // Verificar se o funcionário está vinculado a alguma escala
    $sqlEscala = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE motorista_id = ? OR cobrador_id = ?");
    $sqlEscala->execute([$funcionario_id, $funcionario_id]);  // Duas instâncias de $funcionario_id para ambos os marcadores de posição
    $numEscalas = $sqlEscala->fetchColumn();


        if ($numEscalas > 0) {
            echo '<script>alert("Não é possível excluir o funcionário, pois ele está vinculado a uma escala.");</script>';
        } else {
            // Excluir o funcionário se não estiver vinculado a nenhuma escala
            $sqlExcluir = $pdo->prepare("DELETE FROM funcionarios WHERE id = ?");

            if ($sqlExcluir->execute([$funcionario_id])) {
                echo '<script>alert("Funcionário excluído com sucesso!");</script>';
            } else {
                echo '<script>alert("Erro ao excluir o funcionário.");</script>';
            }
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

// Redirecionar de volta para a página de onde veio ou qualquer outra página desejada
echo '<script>window.location.href = "../visual/opFuncionarios.php";</script>';
}

?>