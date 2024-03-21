<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escalas</title>
    <link rel="stylesheet" href="../estilo/estilo.css">

    <!-- Inclua o script do jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Script da escala -->
    <script src="scriptEscala.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        body {
            background-color: #fff;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #3498db;
            padding: 10px;
            color: #fff;
            text-align: center;
        }

        .dados-usuario {
            margin-bottom: 10px;
        }

        img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
        }

        .alinha-botoes {
            margin-top: 10px;
            text-align: center;
        }

        button {
            background-color: #f39c12;
            color: #fff;
            padding: 8px 16px;
            margin: 0 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e67e22;
        }

        h1 {
            text-align: center;
        }

        .container {
            background-color: #3498db;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 600px;
            color: #fff;
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }

        legend {
            color: #fff;
            font-weight: bold;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #fff;
        }

        input,
        select {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            width: 100%;
        }

        button[name="cadastrarEscala"],
        button[name="excluirEscala"],
        button[name="PesquisarPorFuncionario"],
        button[name="PesquisarPorNumeroEscala"],
        button[name="PesquisarPorVeiculoEscala"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #f39c12;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            background-color: #3498db;
            padding: 10px;
            color: #fff;
            text-align: center;
        }
    </style>
</head>
<body>

<?php

// Inclua a validação de acesso aqui
require "../includes/validar-acesso.inc.php";

// A matrícula agora está disponível na variável de sessão $_SESSION['matricula']
if (isset($_SESSION['matricula'])) {
    $matricula = $_SESSION['matricula'];

    if($matricula == null){
        header("Location: formulario-login.php");
        exit();
    }

    // Consulta para obter dados do usuário usando a matrícula
    $sql = "SELECT nome, matricula, cargo_id FROM adminn WHERE matricula = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$matricula]);
    $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

    $cargo = $dadosUsuario['cargo_id'];

    if ($cargo === 1){
        header("Location: opEscalasFiscal.php");
        exit();
    }

    // Verifique se os dados do usuário foram encontrados
    if ($dadosUsuario) {
        $nomeUsuario = $dadosUsuario['nome'];
        $matricula = $dadosUsuario['matricula'];
    } else {
        // Caso contrário, redirecione ou faça algo apropriado para lidar com a ausência de dados do usuário
        die("Ocorreu um erro inesperado ao buscar os dados do usuário, tente novamente");
    }

    // Define o fuso horário para São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    if ($cargo === 1){
        $cargo = 'Fiscal';
    } else{$cargo = 'Supervisor';}


    // Obtém a data e hora atual
    $dataHoraAtual = date("d/m/Y H:i:s");
}
?>

<header>
    <div class="dados-usuario">
        <p>Usuário: <?php echo $nomeUsuario; ?> - <?php echo $matricula; ?>, <?php echo $cargo?></p>
        <p>Data/Hora: <?php echo $dataHoraAtual; ?></p>
        <a href="../includes/logout.inc.php"><button>Logout</button></a>
    </div>
</header>

<img class="mb-4" src="../imagem/logo.png" alt="" width="250" height="250">

<div class="alinha-botoes">
    <h1> Gerenciamento de Escalas </h1>
    <a href="opEscalas.php"><button>ESCALAS</button></a>
    <a href="opFuncionarios.php"><button>FUNCIONÁRIOS</button></a>
    <a href="opVeiculos.php"><button>VEÍCULOS</button></a>
</div>


<h1> SUPERVISOR </h1>

<!-- Formulário de Inserção de Escalas -->
<div class="container">
    <fieldset>
        <legend>Cadastro de escala</legend>
        <form action="../includes/INSERIR_escala.php" method="POST">
            <br>
            <!-- Campos de inserção -->
            <label for="numero_escala">Número de escala:</label>
            <input type="text" id="numero_escala" name="numero_escala">
            <br><br>

            <label for="pesquisarPorVeiculo">Selecione o veículo: </label>
            <select class="veiculo_id" name="veiculo"></select>
            <br><br>

            <label for="pesquisarPorMotorista">Selecione o motorista: </label>
            <select class="motorista_id" name="motorista"></select>
            <br><br>

            <label id="labelCobrador" for="cobrador">Selecione o cobrador: </label>
            <select id="selectCobrador" class="cobrador_id" name="cobrador">
                <option value="semCobrador">Sem Cobrador</option>
            </select>
            <br><br>

            <label for="horario_inicio">Horário de início:</label>
            <input type="time" id="horario_inicio" name="horario_inicio">
            <br><br>

            <label for="tempo_intervalo">Tempo de intervalo:</label>
            <input type="time" id="tempo_intervalo" name="tempo_intervalo">
            <br><br>

            <label for="horario_final">Horário final:</label>
            <input type="time" id="horario_final" name="horario_final">
            <br><br>
            <label for="fileInput">Selecione um arquivo:</label>
            <input type="file" id="fileInput" name="file"> <br><br>
            <br><br>
            <button name="cadastrarEscala">Cadastrar escala</button>
        </form>
        <fieldset>
</div>

<!-- Formulário de Busca de Escalas -->
<div class="container">
    <fieldset>
        <legend>Sistema de busca/edição</legend>
        <form action="#" method="POST">
            <br>
            <!-- Pesquisar por funcionário -->
            <label for="pesquisarPorFuncionario">Pesquisar por funcionário: </label>
            <select class="funcionario_idPesquisa" name="pesquisaPorFuncionario"></select>
            <br><br>
            <button name="PesquisarPorFuncionario">Exibir escala</button>

            <!-- Pesquisar por número de escala -->
            <br><br>
            <label for="pesquisarPorNumeroEscala">Pesquisar por número de escala: </label>
            <select class="escala_id" name="pesquisarPorEscalaN"></select>
            <br><br>
            <button name="PesquisarPorNumeroEscala">Exibir escala</button>

            <br><br>
            <label for="pesquisarPorVeiculo">Pesquisar por veículo: </label>
            <select class="veiculo_idPesquisa" name="pesquisaPorVeiculo"></select>
            <br><br>
            <button name="PesquisarPorVeiculoEscala">Exibir escala</button>

        </form>
    </fieldset>
</div>

<div class="container">
    <fieldset>
        <legend>Exclusão de escala</legend>
        <form action="../includes/EXCLUIR_escala.php" method="POST">
            <br>
            <label>Selecione o número de escala a se excluir: </label>
            <select name="escalaExcluirID" class="escala_id" name="pesquisarPorEscalaN"></select>
            <br><br>
            <button name="excluirEscala">Excluir escala</button>
        </form>
    </fieldset>
</div>

<?php

// Pesquisa a escala por funcionário
if(isset($_POST['PesquisarPorFuncionario'])){
    require "../includes/pesquisarEscalaPorNome.php";
}

// Pesquisa a escala pelo número de escala
if(isset($_POST['PesquisarPorNumeroEscala'])){
    require "../includes/pesquisarEscalaPorNumero.php";
}

//Pesquisa a escala pelo número de veículo
if(isset($_POST['PesquisarPorVeiculoEscala'])){
    require "../includes/pesquisarEscalaPorVeiculo.php";
}

?>

<br><br>
<footer>
    <p>Feito por Gustavo Rabutske & Gabriel Vitor. Projeto Integrador do CTDS - IFSC</p>
</footer>

</body>
</html>
