<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

// Verifica se o formulário foi enviado
if (isset($_POST['veiculo'])) {
    $pesquisar = strip_tags($_POST['veiculo']);

    $requiredFields = array('veiculo');
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
            // Consulta para buscar informações do veículo
            $sql = $pdo->prepare("SELECT * FROM veiculos WHERE id = :pesquisar");
            $sql->bindParam(':pesquisar', $pesquisar);
            $sql->execute();
            $veiculos = $sql->fetchAll();

            if (count($veiculos) > 0) {
                ?>
                <table>
                    <caption> Informações do veículo </caption>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Número</th>
                        <th>Capacidade</th>
                        <th>Data de cadastro</th>
                        <th>Escalas cadastradas</th>
                    </tr>
                    <?php
                    foreach ($veiculos as $veiculo) {
                        // Consulta para contar o número de escalas associadas ao veículo
                        $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE veiculo_id = :veiculo_id");
                        $sql->bindParam(':veiculo_id', $veiculo[0]);
                        $sql->execute();
                        $numEscalas = $sql->fetchColumn();

                        echo "<tr>";
                        echo "<td>" . $veiculo[0] . "</td>";
                        echo "<td>" . $veiculo[1] . "</td>";
                        echo "<td>" . $veiculo[2] . "</td>";
                        echo "<td>" . $veiculo[3] . "</td>";
                        echo "<td>" . $veiculo[4] . "</td>";
                        echo "<td>" . $numEscalas . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php
            } else {
                echo "<script>alert('Erro: não foi encontrado um veículo com este número (id)')</script>";
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

        function toggleNumeroField() {
            var checkbox = document.getElementById('manterNumeroCheckbox');
            var numeroField = document.getElementById('atualizarNumero');
            var numeroLabel = document.getElementById('labelAtualizarNumero');

            if (checkbox.checked) {
                numeroField.style.display = 'none';
                numeroLabel.style.display = 'none';
                numeroField.value = '';
            } else {
                numeroField.style.display = 'block';
                numeroLabel.style.display = 'block';
            }
        }
    </script>

    <style>
        /* Adicione este trecho ao seu arquivo estilo.css */

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
        <a href='../visual/opVeiculos.php'><button id="limparPesquisa" type="submit">Limpar tela</button></a>
    </div>

    <div class="container">
        <form action="../includes/ATUALIZAR_veiculo.php" method="POST" id="formularioEdicao">
            <fieldset>
                <legend>Atualizar Veículo</legend>
                <br>
                <label for="veiculo_id">Veículo:</label>
                <select class="veiculo_id" id="veiculo_id" name="veiculo_id"></select>

                <br><br>
                <label for="tipo_id">Tipo de Veículo:</label>
                <select class="tipo_id" id="tipo_id_atualizar" name="tipo_id"></select>
                <br><br>

                <label>Manter o número: </label>
                <input type="checkbox" id="manterNumeroCheckbox" name="manter_numero" value="1" onchange="toggleNumeroField()" />
                <br><br>
                <label for="atualizarNumero" id="labelAtualizarNumero">Número:</label>
                <input type="text" id="atualizarNumero" name="numero">
                <br><br>

                <label for="atualizarCapacidade">Capacidade:</label>
                <input type="number" id="atualizarCapacidade" name="capacidade">

                <br><br>
                <button name='atualizarVeiculo'>Salvar alterações</button>
            </fieldset>
        </form>
    </div>
</body>
</html>
