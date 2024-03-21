<?php

// Conexão com o banco de dados usando PDO
require "conexaoBanco.php";

$matricula = trim($_POST['matricula']);
$senha = trim($_POST['senha']);

// Consulta preparada para buscar a senha criptografada no banco de dados
$sql = "SELECT senha FROM adminn WHERE matricula = :matricula";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':matricula', $matricula);
$stmt->execute();

// Fetch da senha armazenada
$senhaArmazenada = $stmt->fetchColumn();


// Verifica se o usuário foi encontrado no banco de dados
if (empty($senhaArmazenada)) {
    echo "<script>alert('Credenciais de autenticação de usuário inválidas. Tente novamente!');</script>";
    exit();
}


// Verifica a senha usando password_verify
if (password_verify($senha, $senhaArmazenada)) {
    // Login e senha verificados. Inicia uma sessão e redireciona para a página restrita
    session_start();
    $_SESSION['conectado'] = true;
    $_SESSION['matricula'] = $matricula; // Adicione esta linha para definir a matrícula na sessão
    header("location: central.php");
} else {
    echo "<script>alert('Credenciais de autenticação de usuário inválidas. Tente novamente!')</script><p></p>";
}
