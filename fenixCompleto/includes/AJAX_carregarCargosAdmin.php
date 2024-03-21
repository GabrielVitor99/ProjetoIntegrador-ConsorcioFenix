<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

$query = "SELECT id, cargo FROM cargos_admin";
$stmt = $pdo->prepare($query);
$stmt->execute();
$cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna como JSON
header("Content-Type: application/json");
echo json_encode($cargos);
?>
