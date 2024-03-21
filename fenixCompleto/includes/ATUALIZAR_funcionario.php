<?php
require "conexaoBanco.php";

// Obtendo os valores do formulário
$funcionario_id = strip_tags($_POST['funcionario_id']);
$telefone = strip_tags($_POST['telefone']);
$cargo = strip_tags($_POST['cargo_id']);

$manterNome = isset($_POST['manter_nome']);
$manterMatricula = isset($_POST['manter_matricula']);

// Verificar se uma das caixas está vazia
$requiredFields = array('funcionario_id', 'telefone', 'cargo_id');
$missingFields = array_filter($requiredFields, function($field) {
    return empty($_POST[$field]);
});

if (!empty($missingFields)) {
    $missingFieldsList = implode(', ', $missingFields);
    echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
    echo '<script>window.location.href = "../visual/opFuncionarios.php";</script>';
} else {
    try {
        // Verificar se a mesma matrícula já existe (exceto se estiver editando a mesma matrícula ou mantendo a mesma matrícula)
        if (!$manterMatricula) {
            $matricula = strip_tags($_POST['matricula']);
            if (empty($matricula)) {
                echo '<script>alert("Matrícula não pode ser vazia.")</script>';
                echo '<script>window.location.href = "../visual/opFuncionarios.php";</script>';
            }
            $sql = $pdo->prepare("SELECT id FROM funcionarios WHERE matricula = ? AND (id != ? OR matricula = ?)");
            $sql->execute(array($matricula, $funcionario_id, $matricula));
            $existingFuncionarioMatricula = $sql->fetch();

            if ($existingFuncionarioMatricula) {
                echo '<script>alert("Matrícula de funcionário já existe. Por favor, escolha outro número.")</script>';
                echo '<script>window.location.href = "../visual/opFuncionarios.php";</script>';
            }
        }

        // Verificar se o mesmo nome já existe (exceto se estiver editando o mesmo nome ou mantendo o mesmo nome)
        if (!$manterNome) {
            $nome = strip_tags($_POST['nome']);
            if (empty($nome)) {
                echo '<script>alert("Nome não pode ser vazio.")</script>';
                echo '<script>window.location.href = "../visual/opFuncionarios.php";</script>';
            }
            $sql = $pdo->prepare("SELECT id FROM funcionarios WHERE nome = ? AND (id != ? OR nome = ?)");
            $sql->execute(array($nome, $funcionario_id, $nome));
            $existingFuncionarioNome = $sql->fetch();

            if ($existingFuncionarioNome) {
                echo '<script>alert("Nome de funcionário já existe. Por favor, escolha outro nome.")</script>';
                echo '<script>window.location.href = "../visual/opFuncionarios.php";</script>';
            }
        }

        // Verificar se o funcionário está em uma escala
        $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE motorista_id = ? OR cobrador_id = ?");
        $sql->execute(array($funcionario_id, $funcionario_id));
        $numEscalas = $sql->fetchColumn();

        if ($numEscalas > 0) {
            echo '<script>alert("O funcionário está associado a uma escala. Não é permitido alterar as suas informações.")</script>';
        } else {
            // Atualizar no banco de dados
            $updateFields = array();
            $params = array();

            if (!$manterNome) {
                $updateFields[] = "nome = ?";
                $params[] = $nome;
            }

            if (!$manterMatricula) {
                $updateFields[] = "matricula = ?";
                $params[] = $matricula;
            }

            $updateFields[] = "telefone = ?";
            $updateFields[] = "cargo_id = ?";
            $params[] = $telefone;
            $params[] = $cargo;
            $params[] = $funcionario_id;

            $sql = $pdo->prepare("UPDATE funcionarios SET " . implode(", ", $updateFields) . " WHERE id = ?");
            
            if ($sql->execute($params)) {
                echo '<script>alert("Funcionário atualizado com sucesso!")</script>';
            } else {
                echo '<script>alert("Erro ao atualizar, verifique se todos os campos foram preenchidos")</script>';
            }
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    echo '<script>window.location.href = "../visual/opFuncionarios.php";</script>';
}
?>
