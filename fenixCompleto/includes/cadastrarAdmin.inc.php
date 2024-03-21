<?php
require "conexaoBanco.php";

// Verificar se o formulário foi enviado
if (isset($_POST['cadastrar'])) {

    // Obter os valores do formulário
    $nome = trim($_POST['nome']);
    $cargo = trim($_POST['cargo_admin']);
    $matricula = trim($_POST['matricula']);
    $senha = trim($_POST['senha']);

    // Verificar se os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($matricula) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
        exit();
    }

    // Verificar se a matrícula já está cadastrada
    $sqlVerificaMatricula = "SELECT COUNT(*) FROM adminn WHERE matricula = ?";
    $stmtVerificaMatricula = $pdo->prepare($sqlVerificaMatricula);
    $stmtVerificaMatricula->execute([$matricula]);
    $matriculaExistente = $stmtVerificaMatricula->fetchColumn();

    if ($matriculaExistente > 0) {
        echo "<script>alert('Matrícula já cadastrada. Escolha uma matrícula diferente.');</script>";
        exit();
    }

    // Criptografar a senha usando Argon2i
    $senhaCriptografada = password_hash($senha, PASSWORD_ARGON2I);

    // Preparar a consulta SQL usando declarações preparadas
    $sql = "INSERT INTO adminn VALUES (null, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

    // Preparar e executar a declaração
    $stmt = $pdo->prepare($sql);

    // Verificar se a preparação foi bem-sucedida
    if ($stmt) {
        // Executar a consulta
        $stmt->execute([$nome, $cargo, $matricula, $senhaCriptografada]);

        // Verificar se a inserção foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            // Inserção bem-sucedida
            // Redirecionar para a página de conteúdo login
            header("location: formulario-login.php");
            exit();
        } else {
            // Inserção falhou
            die("Erro ao inserir no banco de dados.");
        }
    } else {
        // Preparação falhou
        die("Erro na preparação da consulta.");
    }
} else {
    // Formulário não enviado
    die("Acesso inválido.");
}
?>
