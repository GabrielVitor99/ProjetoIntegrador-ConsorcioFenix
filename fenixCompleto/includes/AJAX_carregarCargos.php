<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

// Consulta para buscar empresas
$query = "SELECT id, cargo FROM cargos_funcionario";
$stmt = $pdo->prepare($query);
$stmt->execute();
$cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna as empresas como JSON
header("Content-Type: application/json");
echo json_encode($cargos);
?>
