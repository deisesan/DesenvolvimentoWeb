<?php
$host = "127.0.0.1";
$port = 3306;
$user = "root";
$password = "";
$dbname = "estoque";

$conec = mysqli_connect($host, $user, $password, $dbname, $port);

if (!$conec) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
} else {
    // echo "Conexão realizada com sucesso!";
    $conectou = 1;
}
?>
