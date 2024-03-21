<?php

require "conexaoBanco.php";

  session_start();
  //testamos as condições de erro: a variável de sessão criada no login ou no cadastro não  existe OU a variável de sessão existe, mas está com o valor booleano false
  if(!isset($_SESSION['conectado']) OR $_SESSION['conectado'] != true)
   {
   header("location: formulario-login.php"); //redirecionamos para a página de entrada
   }

?>