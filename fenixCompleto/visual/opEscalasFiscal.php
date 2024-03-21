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

    <!-- Inclua o CSS do Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Inclua o script do Select2 -->
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

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #f39c12;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
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

    // Verifique se os dados do usuário foram encontrados
    if ($dadosUsuario) {
        $nomeUsuario = $dadosUsuario['nome'];
        $matricula = $dadosUsuario['matricula'];
        $cargo = $dadosUsuario['cargo_id'];
    } else {
        // Caso contrário, redirecione ou faça algo apropriado para lidar com a ausência de dados do usuário
        die("Ocorreu um erro inesperado ao buscar os dados do usuário, tente novamente");
        $nomeUsuario = "";
        $matricula = "";
        $cargo = "";
    }


    // Obtém a data e hora atual
    $dataHoraAtual = date("d/m/Y H:i:s");
}
?>

<header>
    <div class="dados-usuario">
        <p>Usuário: <?php echo $nomeUsuario; ?> - <?php echo $matricula; ?>, <?php echo $cargo?></p>
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


<h1> FISCAL </h1>

<!-- Formulário de Busca de Escalas -->
<div class="container">
    <fieldset>
        <legend>Sistema de busca de escala</legend>
        <form action="#" method="POST">
            <br><br>
            <!-- Pesquisar por funcionário -->
            <label for="pesquisarPorFuncionario">Pesquisar por funcionário: </label>
            <select class="funcionario_idPesquisa" name="pesquisaPorFuncionario"></select>
            <br><br>
            <button name="PesquisarPorFuncionario">Exibir escala</button>

            <!-- Pesquisar por número de escala -->
            <br><br><br>
            <label for="pesquisarPorNumeroEscala">Pesquisar por número de escala: </label>
            <select class="escala_id" name="pesquisarPorEscalaN"></select>
            <br><br>
            <button name="PesquisarPorNumeroEscala">Exibir escala</button>

            <!-- Pesquisar por veículos -->
            <br><br><br>
            <label for="pesquisarPorVeiculo">Pesquisar por veículo: </label>
            <select class="veiculo_idPesquisa" name="pesquisaPorVeiculo"></select>
            <br><br>
            <button name="PesquisarPorVeiculoEscala">Exibir escala</button>

            <br><br>
        </form>
    </fieldset>
</div>

<?php
// Pesquisa a escala por funcionário
if(isset($_POST['PesquisarPorFuncionario'])){
    require "../includes/pesquisarEscalaPorNomeFiscal.php";
}

// Pesquisa a escala pelo número de escala
if(isset($_POST['PesquisarPorNumeroEscala'])){
    require "../includes/pesquisarEscalaPorNumeroFiscal.php";
}

//Pesquisa a escala pelo número de veículo
if(isset($_POST['PesquisarPorVeiculoEscala'])){
    require "../includes/pesquisarEscalaPorVeiculoFiscal.php";
}

?>
<br><br>
<footer>
    <p>Feito por Gustavo Rabutske & Gabriel Vitor. Projeto Integrador do CTDS - IFSC</p>
</footer>

</body>
</html>
