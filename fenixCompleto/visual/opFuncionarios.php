<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários</title>
    <link rel="stylesheet" href="../estilo/estilo.css">

    <!-- Inclua o script do jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Inclua o CSS do Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Inclua o script do Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Script do funcionário -->
    <script src="scriptFuncionario.js"></script>

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

        button[name="cadastrarFuncionario"],
        button[name="pesquisarFuncionario"],
        button[name="excluirFuncionario"],
        button[name="listar"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #f39c12;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    }

    if ($cargo === 1){
        $cargo = 'Fiscal';
    } else{$cargo = 'Supervisor';}


    // Define o fuso horário para São Paulo
    date_default_timezone_set('America/Sao_Paulo');

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


<!-- Formulário para a tabela "funcionários" -->
<div class="container">
    <fieldset>
        <legend>Cadastrar Funcionário</legend>
        <form action="../includes/INSERIR_funcionario.php" method="POST">

            <br>
            <label for="nome">Nome do Funcionário:</label>
            <input type="text" id="nome" name="nome">
            <br><br>

            <label for="matricula">Matrícula:</label>
            <input type="number" id="matricula" name="matricula">
            <br><br>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone">
            <br> <br>

            <label for="cargo_funcionario">Cargo:</label>
            <select class="cargo_id" name="cargo_funcionario"></select>
            <br><br><br>

            <button name='cadastrarFuncionario'>Cadastrar Funcionário</button>
        </form>
    </fieldset>
</div>

<div class="container">
    <fieldset>
        <legend>Operações de Banco de Dados</legend>
        <form action="#" method="POST">
            <br>
            <label for="tipo_busca">Selecione a tabulação de dados:</label>
            <select name="tipo_busca">
                <option style="background-color:green" value="todos">Listar todos os funcionários</option>
                <option style="background-color:yellow" value="motoristas">Listar todos os motoristas</option>
                <option style="background-color:yellow" value="cobradores">Listar todos os cobradores</option>
            </select>
            <br><br>
            <button name="listar">Listar</button>
            <br><br>

            <label for="funcionario_id">Selecione o funcionário para pesquisar/editar:</label>
            <select class="funcionario_id" id="funcionario_id" name="funcionario"></select>
            <br><br><br>
            <button name="pesquisarFuncionario">Pesquisar/editar</button>

            <br><br>
            <label for="funcionario_id_excluir">Selecione o funcionário a ser excluído</label>
            <select class="funcionario_id" id="funcionario_id_excluir" name="funcionario_id_excluir"></select>
            <br><br><br>
            <button name="excluirFuncionario">Excluir</button>
        </form>
    </fieldset>
</div>

<?php

// Pesquisar/editar o veículo selecionado no select "veiculo_id"
if (isset($_POST['pesquisarFuncionario'])) {
    require "../includes/buscaEdicaoFuncionario.php";
}

if (isset($_POST['excluirFuncionario'])) {
    require "../includes/EXCLUIR_funcionario.php";
}

require "../includes/conexaoBanco.php";

if (isset($_POST['listar'])) {
    // Verifique se o botão "listar" foi pressionado
    $tipo_busca = $_POST['tipo_busca'];

    // Defina a consulta SQL com base no tipo de busca selecionado
    if ($tipo_busca === 'todos') {
        $sql = $pdo->prepare("SELECT * FROM funcionarios");
    } elseif ($tipo_busca === 'motoristas') {
        $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE cargo_id = 1");
    } elseif ($tipo_busca === 'cobradores') {
        $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE cargo_id = 2");
    }

    $sql->execute();
    $funcionarios = $sql->fetchAll();

    if (count($funcionarios) > 0) {
        // Se houver resultados, exiba-os
        echo "<table>
        <caption> Informações dos funcionários </caption>
        <br>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Cargo</th>
            <th>Telefone</th>
            <th>Data de cadastro</th>
            <th>Possuí escala</th>
        </tr>";

        foreach ($funcionarios as $funcionario) {
            // Consulta para contar o número de escalas associadas ao veículo
            $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE motorista_id = :funcionario_id or cobrador_id = :funcionario_id");
            $sql->bindParam(':funcionario_id', $funcionario[0]);
            $sql->execute();
            $numEscalas = $sql->fetchColumn();
            if($numEscalas > 0){
                $numEscalas = "SIM";
            } else{
                $numEscalas = "NÃO";
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

        echo "</table>";
    } else {
        echo "<script>alert('Nenhum veículo encontrado para a opção selecionada.')</script>";
    }
}
?>

<br><br>
<footer>
    <p>Feito por Gustavo Rabutske & Gabriel Vitor. Projeto Integrador do CTDS - IFSC</p>
</footer>
</body>
</html>
