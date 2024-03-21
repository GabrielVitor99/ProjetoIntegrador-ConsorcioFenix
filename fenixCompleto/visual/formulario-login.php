<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title> Login de usuário </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilo/estilo-login.css">
    <script src="https://kit.fontawesome.com/101e03fd9a.js" crossorigin="anonymous"></script>
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #3498db; /* Cor de fundo azul */
            margin: 0; /* Remova as margens padrão do body */
        }

        .form-signing {
            background-color: white;
            padding: 20px;
            border-radius: 10px; /* Borda arredondada */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
            max-width: 350px; /* Largura máxima do formulário */
            width: 100%; /* Largura de 100% para preencher o espaço disponível */
            text-align: center; /* Alinhamento centralizado do conteúdo */
            box-sizing: border-box; /* Evitar que as bordas afetem a largura total */
        }

        .form-signing img {
            max-width: 100%; /* Garantir que a imagem não ultrapasse a largura do formulário */
            margin-bottom: 20px; /* Adicionar margem na parte inferior da imagem */
        }
    </style>
</head>

<body class="text-center">

<!--formulário de login-->

<form action="formulario-login.php" method="post" class="form-signing">
    <h1 class="h3 mb-3 font-weight-normal">Login</h1>
    <img class="mb-4" src="../imagem/logo.png" alt="" width="250" height="250">
    <!--<h1 class="h3 mb-3 font-weight-normal">Login</h1>-->
    <label for="inputEmail" class="sr-only">Matricula</label>
    <input type="text" name="matricula" id="inputEmail" class="form-control" placeholder="Matricula" required="" autofocus="">
    <br>
    <label for="inputPassword" class="sr-only">Senha</label>
    <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required="">
    <br>

    <button name="logar" class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

    <p class="mt-5 mb-3 text-muted">© 2023</p>

    <a href="formulario-cadastro.php" title="cadastro" target="_blank"> Ir para o cadastro </a> <br>


</form>

<?php
//receber os dados do formulário
if(isset($_POST['logar']))
{
    require_once "../includes/logar.inc.php";
}
?>

</body>
</html>
