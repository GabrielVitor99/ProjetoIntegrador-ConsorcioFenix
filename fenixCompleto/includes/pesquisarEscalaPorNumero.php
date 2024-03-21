<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

//echo "<script>alert('Funcionalidade indisponivel no momento')</script>";

$pesquisar = strip_tags($_POST['pesquisarPorEscalaN']);
// Verificar se uma das caixas está vazia
$requiredFields = array('pesquisarPorEscalaN');
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

$sql = $pdo->prepare("SELECT * FROM escalas WHERE id = :pesquisar");
$sql->bindParam(':pesquisar', $pesquisar);
$sql->execute();
$tabular = $sql->fetchAll();

$num_nome = count($tabular);

if(count($tabular) > 0){

// estilo da tabulação dos dados
echo "<table>
<caption> Escala de número: $num_nome </caption>
<tr>
  <th>ID</th>
  <th>Número de escala</th>
  <th>Veículo</th>
  <th>Motorista</th>
  <th>Cobrador</th>
  <th>Início da jornada</th>
  <th>Tempo de intervalo</th>
  <th>Final da jornada</th>
  <th>Arquivo da escala</th>
  <th>Data de cadastro</th>
</tr>";
foreach ($tabular as $key => $value) {
    echo "<tr>";
    echo "<td>" . $value[0] . "</td>";
    echo "<td>" . $value[1] . "</td>";
    echo "<td>" . $value[2] . "</td>";
    echo "<td>" . $value[3] . "</td>";
    echo "<td>" . $value[4] . "</td>";
    echo "<td>" . $value[5] . "</td>";
    echo "<td>" . $value[6] . "</td>";
    echo "<td>" . $value[7] . "</td>";
    echo "<td><a href='" . $value[8] . "'download>Download</a></td>";
    echo "<td>" . $value[9] . "</td>";
    echo "</tr>";
}
echo "</table>";


} else {
  echo "<script>alert('Erro: número de escala inexistente')</script>";
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

    function toggleVeiculoField() {
        toggleSelect2Field(
            'manterVeiculoCheckbox',
            'veiculo_id_atualizar',
            'labelAtualizarVeiculo'
        );
    }

    function toggleMotoristaField() {
        toggleSelect2Field(
            'manterMotoristaCheckbox',
            'motorista_id_atualizar',
            'labelAtualizarMotorista'
        );
    }

    function toggleCobradorField() {
        toggleSelect2Field(
            'manterCobradorCheckbox',
            'cobrador_id_atualizar',
            'labelAtualizaCobrador'
        );
    }

    function toggleArquivoField() {
        toggleField(
            'manterArquivoCheckbox',
            'fileInput_atualizar',
            'labelAtualizarAquivo'
        );
    }

    function toggleSelect2Field(checkboxId, fieldId, labelId) {
        var checkbox = document.getElementById(checkboxId);
        var field = document.getElementById(fieldId);
        var label = document.getElementById(labelId);

        if (checkbox.checked) {
            field.style.display = 'none';
            label.style.display = 'none';
            field.value = '';

            // Destruir o Select2 ao ocultar o campo
            $('#' + fieldId).select2('destroy');
        } else {
            field.style.display = 'block';
            label.style.display = 'block';

            // Recarregar o Select2 ao exibir o campo
            $('#' + fieldId).select2();
        }
    }

    function toggleField(checkboxId, fieldId, labelId) {
        var checkbox = document.getElementById(checkboxId);
        var field = document.getElementById(fieldId);
        var label = document.getElementById(labelId);

        if (checkbox.checked) {
            field.style.display = 'none';
            label.style.display = 'none';
            field.value = '';
        } else {
            field.style.display = 'block';
            label.style.display = 'block';
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
        <a href='../visual/opEscalas.php'><button id="limparPesquisa" type="submit">Limpar tela</button></a>
    </div>

    <div class="container">
        <form action="../includes/ATUALIZAR_escala.php" method="POST" id="formularioEdicao">
            <fieldset>
                <legend>Atualizar escala</legend>
                <label for="escala_id">Escala a se atualizar:</label>
                <select class="escala_id" id="escala_id_atualizar" name="escala_id_atualizar"></select>

                <label>Manter mesmo veículo: </label>
                <input type="checkbox" id="manterVeiculoCheckbox" name="manter_veiculo" value="1" onchange="toggleVeiculoField()" />
                <label for="atualizarVeiculo" id="labelAtualizarVeiculo">Veículo:</label>
                <select class="veiculo_id" id="veiculo_id_atualizar" name="veiculo_id_atualizar"></select>

                <label>Manter o mesmo motorista: </label>
                <input type="checkbox" id="manterMotoristaCheckbox" name="manter_motorista" value="1" onchange="toggleMotoristaField()" />
                <label for="atualizarMotorista" id="labelAtualizarMotorista">Motorista:</label>
                <select class="motorista_id" id="motorista_id_atualizar" name="motorista_id_atualizar"></select>

                <label>Manter o mesmo cobrador: </label>
                <input type="checkbox" id="manterCobradorCheckbox" name="manter_cobrador" value="1" onchange="toggleCobradorField()" />
                <label for="atualizarCobrador" id="labelAtualizaCobrador">Cobrador:</label>
                <select class="cobrador_id" id="cobrador_id_atualizar" name="cobrador_id_atualizar"></select>

                <label for="horario_inicio">Horário de início:</label>
                <input type="time" id="horario_inicio_atualizar" name="horario_inicio_atualizar">

                <label for="tempo_intervalo">Tempo de intervalo:</label>
                <input type="time" id="tempo_intervalo_atualizar" name="tempo_intervalo_atualizar">

                <label for="horario_final">Horário final:</label>
                <input type="time" id="horario_final_atualizar" name="horario_final_atualizar">

                <label>Manter mesmo arquivo de escala: </label>
                <input type="checkbox" id="manterArquivoCheckbox" name="manter_arquivo" value="1" onchange="toggleArquivoField()" />
                <label for="atualizarVeiculo" id="labelAtualizarAquivo">Selecione um arquivo:</label>
                <input type="file" id="fileInput_atualizar" name="file_atualizar"> <br><br>

                <br>
                <button name='atualizarEscala'>Salvar alterações</button>
            </fieldset>
        </form>
    </div>

</body>
</html>