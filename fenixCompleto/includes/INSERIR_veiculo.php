<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

$numero = strip_tags($_POST['numero']);
$capacidade = strip_tags($_POST['capacidade']);
$tipo = strip_tags($_POST['tipo_id']);

    // Verificar se uma das caixas está vazia
    $requiredFields = array('tipo_id', 'numero', 'capacidade');
    $missingFields = array();

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        $missingFieldsList = implode(', ', $missingFields);
        echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
        echo '<script>window.location.href = "../visual/opVeiculos.php";</script>';
    } else {
            // Verificar se já existem os mesmos dados cadastrados
            $sql_verificar = $pdo->prepare("SELECT COUNT(*) FROM `veiculos` WHERE numero = ?");
            $sql_verificar->execute(array($numero));
            // Ele soma os nomes e/ou matrículas do mesmo que já estão cadastradas
            $erro = $sql_verificar->fetchColumn();

            if ($erro > 0) {
                echo '<script>alert("Já existe um veículo cadastrado com o mesmo número.")</script>';
                echo '<script>window.location.href = "../visual/opVeiculos.php";</script>';
            }
            else {
                // Restante do código para inserir no banco de dados
                $sql = $pdo->prepare("INSERT INTO `veiculos` (tipo_id, numero, capacidade) 
                VALUES (?, ?, ?)");

                if ($sql->execute(array($tipo, $numero, $capacidade))) {
                    echo '<script>alert("Veículo cadastrado com sucesso!")</script>';
                } else {
                    die("Falhou");
                }
            }
            echo '<script>window.location.href = "../visual/opVeiculos.php";</script>';

        }
?>