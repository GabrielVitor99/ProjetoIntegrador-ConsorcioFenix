<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consórcio Connect</title>
    <link rel="stylesheet" href="../estilo/style.css">

    <script src="https://kit.fontawesome.com/101e03fd9a.js" crossorigin="anonymous"></script>
    <!-- Inclua o script do jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Inclua o CSS do Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Inclua o script do Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Script do cadastro de usuário -->
    <script src="scriptCadastroAdmin.js"></script>

    <script src="../JavaScript/mudar-body.js"></script> <!-- Esse JS muda a class do body o que ajuda pra fazer as animações -->

</head>
<body>
    <form action="" method="post">

    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primario">Já terminou?</h2>
                <p class="description">Volte e faça o login</p>
                <button id="login" class="btn btn-primario">Logar</button> <!-- Esse botão leva pra parte de login -->
            </div>
            <div class="second-column">
                <h2 class="title title-secundario">Crie um cadastro</h2>
                <p class="description description-primario">Preencha todos os campos abaixo</p>
                <!--<form class="form"> // Formulário para o cadastro -->

                    <label class="label-input" for="">
                        <i class="far fa-user icon-modifica"></i>
                        <input type="text" name="nome" placeholder="Nome">
                    </label>

                    <label class="label-input" for="">
                        <i class="far fa-user icon-modifica"></i>
                        <input type="text" name="matricula" placeholder="Matricula">
                    </label>

                    <label class="label-input" for="">
                        <i class="fas fa-briefcase icon-modifica"></i><br>
                        <select class="cargo_id" name="cargo_admin"></select>
                    </label>

                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modifica"></i>
                        <input type="password" name="senha" id="senha" placeholder="Senha">
                    </label>


                    <button type="submit" name="cadastrar" class="btn btn-secundario">Fazer cadastro</button> <!-- Esse botão valida o cadastro, pode colocar um alert quando o cadastro der certo -->

            </div><!-- Segunda coluna -->


        </div><!-- Primeiro conteúdo -->
        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primario">Ainda não tem conta?</h2>
                <p class="description">Faça o cadastro</p>
                <button id="cadastrar" class="btn btn-primario">Cadastrar</button> <!-- Esse botão leva pra parte de cadastro -->
            </div>
            <div class="second-column">
                <h2 class="title title-secundario">Consórcio Connect</h2>
                <p class="description description-primario">Para entrar preencha os campos abaixo</p>
                <form class="form"> <!-- Formulário para o login -->

                    <label class="label-input" for="">

                        <input type="text" name="matricula" id="matricula" placeholder="Matricula">
                    </label>

                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modifica"></i>
                        <input type="password" name="senha" id="senha" placeholder="Senha">
                    </label>
                    <a href="#" class="esqueceu">Esqueceu sua senha?</a> <!-- Isso não precisa necessáriamente funcionar -->
                    <button type="submit" name="logar" class="btn btn-secundario">Fazer login</button> <!-- Esse botão valida o login e leva pro sistema mesmo -->
                </form>
            </div><!-- Segunda coluna -->
        </div><!-- Segundo conteúdo -->
    </div>

    </form>
<?php

    if(isset($_POST['cadastrar']))
    {
        require_once "../includes/cadastrarAdmin.inc.php";
    }

    //receber os dados do formulário
    if(isset($_POST['logar']))
    {
        require_once "../includes/logar.inc.php";
    }
?>
</body>
</html>



