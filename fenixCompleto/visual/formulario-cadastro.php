<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title> Cadastro de usuário </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/formata-formulario.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="scriptCadastroAdmin.js"></script>

    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #3498db;
            margin: 0;
        }

        .form-signing {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 350px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        .form-signing img {
            max-width: 100%;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="text-center">

<form action="formulario-cadastro.php" method="post" class="form-signing">
    <h1 class="mb-4">Cadastrar</h1>
    <img class="mb-4" src="../imagem/logo.png" alt="" width="150" height="150">

    <label for="nome" class="sr-only">Nome completo</label>
    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo" autofocus>
    <br>
    <label for="cargo_admin" class="sr-only">Cargo</label>
    <select class="cargo_id form-control" name="cargo_admin"></select>
    <br><br>
    <label for="matricula" class="sr-only">Matrícula</label>
    <input type="number" name="matricula" id="matricula" class="form-control" placeholder="Matrícula">
    <br>
    <label for="senha" class="sr-only">Senha</label>
    <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha">
    <br>

    <button name="cadastrar" class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar usuário</button>

    <p class="mt-5 mb-3 text-muted">© 2023</p>

    <a href="formulario-login.php" title="login" target="_blank">Ir para o login</a>
</form>

<?php
if(isset($_POST['cadastrar']))
{
    require_once "../includes/cadastrarAdmin.inc.php";
}
?>

</body>
</html>
