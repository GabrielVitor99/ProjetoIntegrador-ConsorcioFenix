<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

// Consulta para buscar tipos de veiculo
$query = "SELECT id, tipo FROM tipos_veiculo";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna os tipos como JSON
header("Content-Type: application/json");
echo json_encode($tipos);
?>
