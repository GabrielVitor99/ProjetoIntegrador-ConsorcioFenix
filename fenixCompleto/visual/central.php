<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de operações</title>
    <link rel="stylesheet" href="../estilo/estilo.css">
    <style>
        body {
            background-color: #fff; /* Fundo branco */
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #3498db; /* Cabeçalho azul */
            padding: 8px; /* Reduzindo o padding */
            color: #fff; /* Texto branco */
            text-align: center;
        }

        .dados-usuario {
            margin-bottom: 8px; /* Reduzindo a margem inferior */
        }

        img {
            display: block;
            margin: 0 auto; /* Centralizar a imagem */
            max-width: 100%; /* Tornando a imagem responsiva */
        }

        footer {
            background-color: #3498db;
            padding: 10px; /* Reduzindo o padding */
            color: #fff;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .alinha-botoes {
            margin-top: 10px;
        }

        button {
            background-color: #f39c12; /* Cor laranja para os botões */
            color: #fff; /* Texto branco */
            padding: 8px 16px; /* padding dos botões */
            margin-right: 8px; /* margem direita */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e67e22; /* Cor laranja mais escura no hover */
        }

    </style>
</head>
<body>

<?php
//  validação de acesso aqui
require "../includes/validar-acesso.inc.php";

require "../includes/conexaoBanco.php";

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
    }

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

<!--RODAPE-->
<footer>

        <p> Feito por Gustavo Rabutske & Gabriel Vitor. Projeto Integrador do CTDS - IFSC </p>

</footer>

</body>
</html>
