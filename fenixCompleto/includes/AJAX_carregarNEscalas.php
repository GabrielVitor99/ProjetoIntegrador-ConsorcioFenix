<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

// Consulta para buscar número de escalas
$query = "SELECT id, numero_escala FROM escalas";
$stmt = $pdo->prepare($query);
$stmt->execute();
$nEscalas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna as escalas como JSON
header("Content-Type: application/json");
echo json_encode($nEscalas);
?>
