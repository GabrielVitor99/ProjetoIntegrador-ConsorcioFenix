<?php

// Conexão com o banco de dados
require "conexaoBanco.php";

$numero = strip_tags($_POST['numero_escala']);
$veiculo = strip_tags($_POST['veiculo']);
$motorista = strip_tags($_POST['motorista']);
$cobrador = strip_tags($_POST['cobrador']);
$horario_inicio = strip_tags($_POST['horario_inicio']);
$tempo_intervalo = strip_tags($_POST['tempo_intervalo']);
$horario_final = strip_tags($_POST['horario_final']);
$arquivo = strip_tags($_POST['file']);

// Verificar se uma das caixas está vazia
$requiredFields = array('numero_escala', 'veiculo', 'motorista', 'horario_inicio', 'tempo_intervalo', 'horario_final', 'file');
$missingFields = array();

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    $missingFieldsList = implode(', ', $missingFields);
    echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
    echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
} else {
    // Verificar se já existem os mesmos dados cadastrados
    $sql_verificar = $pdo->prepare("SELECT COUNT(*) FROM `escalas` WHERE numero_escala = ? OR motorista_id = ? OR cobrador_id = ?");
    $sql_verificar->execute(array($numero, $motorista, $cobrador));

    // Ele soma os nomes e/ou matrículas do mesmo que já estão cadastradas
    $erro = $sql_verificar->fetchColumn();

    if ($erro > 0) {
        echo '<script>alert("Já existe uma escala cadastrada com o mesmo número de escala e/ou motorista e/ou cobrador.")</script>';
        echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
    } else {
        // Restante do código para inserir no banco de dados
        $sql = $pdo->prepare("INSERT INTO `escalas` (numero_escala, veiculo_id, motorista_id, cobrador_id, inicio_jornada, tempo_intervalo, final_jornada, arquivo) 
        VALUES (?, ?, ?, IF(?='', NULL, (SELECT id FROM funcionarios WHERE nome = ?)), ?, ?, ?, ?)");

        if ($sql->execute(array($numero, $veiculo, $motorista, $cobrador, $cobrador, $horario_inicio, $tempo_intervalo, $horario_final, $arquivo))) {
            echo '<script>alert("Escala cadastrada com sucesso!")</script>';
        } else {
            die("Falhou");
        }
    }
    echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
}
?>
