<?php
session_start(); //Inicia sessão
session_unset(); //limpa variaveis
session_destroy(); //destroi sessão
header('Location:index.php');
?>