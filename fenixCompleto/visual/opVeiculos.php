<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
    <!-- Inclua o script do jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Script do veículo -->
    <script src="scriptVeiculos.js"></script>

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

        button[name="cadastrarVeiculo"],
        button[name="pesquisarVeiculo"],
        button[name="excluirVeiculo"],
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

// Verifica se a matrícula está definida na sessão
if (isset($_SESSION['matricula'])) {
    // Obtém a matrícula da sessão
    $matricula = $_SESSION['matricula'];

    // Redireciona para o formulário de login se a matrícula estiver vazia
    if($matricula == null){
        header("Location: formulario-login.php");
        exit();
    }

    // Consulta para obter dados do usuário usando a matrícula
    $sql = "SELECT nome, matricula, cargo_id FROM adminn WHERE matricula = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$matricula]);
    $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se os dados do usuário foram encontrados
    if ($dadosUsuario) {
        // Obtém dados específicos do usuário
        $nomeUsuario = $dadosUsuario['nome'];
        $matricula = $dadosUsuario['matricula'];
        $cargo = $dadosUsuario['cargo_id'];
    } else {
        // Lida com a ausência de dados do usuário
        die("Ocorreu um erro inesperado ao buscar os dados do usuário, tente novamente");
    }

    // Define o fuso horário para São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    // Obtém a data e hora atual no fuso horário de São Paulo
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

<!-- Formulário para inserção de veículos -->
<div class="container">
    <fieldset>
        <legend>Cadastro de Veículos</legend>
        <form action="../includes/INSERIR_veiculo.php" method="POST">
            <br>
            <label for="tipo">Tipo de veículo:</label>
            <select class="tipo_id" id="tipo_id" name="tipo_id"></select>
            <br><br>

            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero">
            <br><br>

            <label for="capacidade">Capacidade:</label>
            <input type="number" id="capacidade" name="capacidade">
            <br><br>

            <button name='cadastrarVeiculo'>Cadastrar veículo</button>
        </form>
    </fieldset>
</div>

<!-- Operações de banco de dados dos veículos -->
<div class="container">
    <fieldset>
        <legend>Operações de veículos</legend>
        <form action="#" method="POST">
            <label for="tipo_busca">Tabular todos os seguintes veículos: </label>
            <select name="tipo_busca">
                <option value="todos">Listar todos os veículos</option>
                <option value="todosComEscala">Listar veículos sem escala</option>
                <option value="todosSemEscala">Listar veículos com escala</option>
                <option value="padrao">Listar padrões</option>
                <option value="executivo">Listar executivos</option>
                <option value="articulado">Listar articulados</option>
            </select>

            <br><br>

            <button name="listar">Listar</button>
            <br><br>

            <!-- Busca personalizada -->
            <label for="veiculo_search">Selecione o veículo a ser pesquisado ou editado:</label>
            <select class="veiculo_id" id="veiculo_id" name="veiculo"></select>
            <br><br>
            <button name="pesquisarVeiculo">Pesquisar/Editar</button>
            <br>

            <label for="veiculo_search">Selecione o veículo a ser excluído</label>
            <select class="veiculo_id" id="veiculo_id_excluir" name="veiculo_id_excluir"></select>
            <br><br>
            <!-- Ao excluir, perguntar se deseja realmente fazer, mas se houver escala cadastrada com o veículo, impedir a ação -->
            <button name="excluirVeiculo">Excluir</button>
        </form>
    </fieldset>
</div>

<?php
// Pesquisar/editar o veículo selecionado no select "veiculo_id"
if (isset($_POST['pesquisarVeiculo'])) {
    require "../includes/buscaEdicaoVeiculo.php";
}

if (isset($_POST['excluirVeiculo'])) {
    require "../includes/EXCLUIR_veiculo.php";
}

// Conexão com o banco de dados
require "../includes/conexaoBanco.php";

// Listar os veículos de acordo com o tipo de busca
if (isset($_POST['listar'])) {
    // Verifique se o botão "listar" foi pressionado
    $tipo_busca = $_POST['tipo_busca'];

    // Defina a consulta SQL com base no tipo de busca selecionado
    if ($tipo_busca === 'todos') {
        $sql = $pdo->prepare("SELECT * FROM veiculos");
    } elseif ($tipo_busca === 'padrao') {
        $sql = $pdo->prepare("SELECT * FROM veiculos WHERE tipo_id = 1");
    } elseif ($tipo_busca === 'executivo') {
        $sql = $pdo->prepare("SELECT * FROM veiculos WHERE tipo_id = 2");
    } elseif ($tipo_busca === 'articulado') {
        $sql = $pdo->prepare("SELECT * FROM veiculos WHERE tipo_id = 3");
    } elseif ($tipo_busca === 'todosComEscala') {
        // Buscar veículos sem escalas
        $sql = $pdo->prepare("
            SELECT *
            FROM veiculos
            WHERE id NOT IN (SELECT veiculo_id FROM escalas)
        ");
    } elseif ($tipo_busca === 'todosSemEscala') {
        // Buscar veículos com escalas
        $sql = $pdo->prepare("
            SELECT veiculos.*
            FROM veiculos
            JOIN escalas ON veiculos.id = escalas.veiculo_id
        ");
    }
    $sql->execute();
    $veiculos = $sql->fetchAll();

    if (count($veiculos) > 0) {
        // Se houver resultados, exiba-os
        ?>
        <table>
            <caption> Informações dos veículos </caption>
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
        echo "<script>alert('Nenhum veículo encontrado para a opção selecionada.')</script>";
        //die("Nenhum veículo encontrado para a opção encontrada.");
    }

    ?>

    <div class="alinha-botoes">
        <br><br>
        <a href='opVeiculos.php'><button id="limparPesquisa" type="submit">Limpar pesquisa</button></a>
    </div>
    <?php
}
?>
<br><br>
<footer>
    <p>Feito por Gustavo Rabutske & Gabriel Vitor. Projeto Integrador do CTDS - IFSC</p>
</footer>
</body>
</html>
