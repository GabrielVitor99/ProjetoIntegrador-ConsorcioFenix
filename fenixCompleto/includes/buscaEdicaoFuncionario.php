<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

// Verifica se o formulário foi enviado
if (isset($_POST['funcionario'])) {
    $pesquisar = strip_tags($_POST['funcionario']);

    $requiredFields = array('funcionario');
    $missingFields = array();

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        $missingFieldsList = implode(', ', $missingFields);
        echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
    } else {
        try {
            // Consulta para buscar informações do funcionário
            $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE id = :pesquisar");
            $sql->bindParam(':pesquisar', $pesquisar);
            $sql->execute();
            $funcionarios = $sql->fetchAll();

            if (count($funcionarios) > 0) {
                ?>
                <table>
                    <caption> Informações do funcionário </caption>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Matrícula</th>
                        <th>Cargo</th>
                        <th>Telefone</th>
                        <th>Data de cadastro</th>
                        <th>Possuí escala</th>
                    </tr>
                    <?php
                    foreach ($funcionarios as $funcionario) {
                        // Consulta para contar o número de escalas associadas ao funcionário
                        $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE motorista_id = :funcionario_id OR cobrador_id = :funcionario_id");
                        $sql->bindParam(':funcionario_id', $funcionario[0]);
                        $sql->execute();
                        $numEscalas = $sql->fetchColumn();

                        if($numEscalas == 0){
                            $numEscalas = "NÃO";
                        } else{
                            $numEscalas = "SIM";
                        }

                        echo "<tr>";
                        echo "<td>" . $funcionario[0] . "</td>";
                        echo "<td>" . $funcionario[1] . "</td>";
                        echo "<td>" . $funcionario[2] . "</td>";
                        echo "<td>" . $funcionario[3] . "</td>";
                        echo "<td>" . $funcionario[4] . "</td>";
                        echo "<td>" . $funcionario[5] . "</td>";
                        echo "<td>" . $numEscalas . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php
            } else {
                echo "<script>alert('Erro: não foi encontrado um funcionário com este número (id)')</script>";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilo/estilo.css">
    <script>
    function exibirFormulario() {
        var formulario = document.getElementById('formularioEdicao');
        formulario.style.display = 'block';
    }

    function toggleNomeField() {
        var checkboxNome = document.getElementById('manterNomeCheckbox');
        var nomeField = document.getElementById('atualizarNome');
        var nomeLabel = document.getElementById('labelAtualizarNome');

        if (checkboxNome.checked) {
            nomeField.style.display = 'none';
            nomeLabel.style.display = 'none';
            nomeField.value = '';
        } else {
            nomeField.style.display = 'block';
            nomeLabel.style.display = 'block';
        }
    }

    function toggleMatriculaField() {
        var checkboxMatricula = document.getElementById('manterMatriculaCheckbox');
        var matriculaField = document.getElementById('atualizarMatricula');
        var matriculaLabel = document.getElementById('labelAtualizarMatricula');

        if (checkboxMatricula.checked) {
            matriculaField.style.display = 'none';
            matriculaLabel.style.display = 'none';
            matriculaField.value = '';
        } else {
            matriculaField.style.display = 'block';
            matriculaLabel.style.display = 'block';
        }
    }
</script>

    <style>

        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            background-color: #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        legend {
            font-size: 24px;
            font-weight: bold;
        }

        form {
            margin-top: 20px;
            background-color: #3498db;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"],
        input[type="time"],
        select {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        button {
            background-color: #f39c12;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e67e22;
        }

        .alinha-botoes {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #formularioEdicao {
            display: none;
        }

        .checkbox-label {
            display: inline-block;
            margin-right: 10px;
        }

    </style>


</head>
<body>
    <div class="alinha-botoes">
        <p>Deseja editar? Se sim, clique em "Editar"</p>
        <button id="editarFormulario" onclick="exibirFormulario()">Editar</button>
        <a href='../visual/opFuncionarios.php'><button id="limparPesquisa" type="submit">Limpar tela</button></a>
    </div>

    <div class="container">
        <form action="../includes/ATUALIZAR_funcionario.php" method="POST" id="formularioEdicao">
            <fieldset>
                <legend>Atualizar funcionário</legend>
                <label for="funcionario_id">Funcionário:</label>
                <select class="funcionario_id" id="funcionario_id" name="funcionario_id"></select>
                <br><br>

                <label>Manter o nome: </label>
                <input type="checkbox" id="manterNomeCheckbox" name="manter_nome" value="1" onchange="toggleNomeField()" />
                <label for="atualizarNome" id="labelAtualizarNome">Nome:</label>
                <input type="text" id="atualizarNome" name="nome">
                <br>

                <label>Manter a matricula: </label>
                <input type="checkbox" id="manterMatriculaCheckbox" name="manter_matricula" value="1" onchange="toggleMatriculaField()" />
                <br>
                <label for="atualizarMatricula" id="labelAtualizarMatricula">Matrícula:</label>
                <input type="number" id="atualizarMatricula" name="matricula">

                <br>
                <label for="cargo_id">Cargo do funcionário:</label>
                <select class="cargo_id" id="cargo_id_atualizar" name="cargo_id"></select>
                <br><br>

                <label for="atualizarTelefone">Telefone:</label>
                <input type="text" id="atualizarTelefone" name="telefone">

                <br><br>
                <button name='atualizarFuncionario'>Salvar alterações</button>
            </fieldset>
        </form>
    </div>
</body>
</html>
