<?php
include 'conexao.php';
$id = $_GET['id'];
$sql = "DELETE FROM produto WHERE id_estoque = $id";
mysqli_query($conec, $sql);
header("Location: listar_produtos.php");
?>