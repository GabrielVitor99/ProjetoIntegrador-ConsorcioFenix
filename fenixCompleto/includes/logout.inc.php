<?php
 //esta include apaga a variável de sessão, desconecta o usuário de nossa aplicação e o envia de volta para formulario-login.php

 require "conexaoBanco.php";
 
 session_start();
 $_SESSION = array();
 session_destroy();
 header("location: ../visual/formulario-login.php");
 ?>