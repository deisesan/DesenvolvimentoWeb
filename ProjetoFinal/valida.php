<?php
$usuario = $_POST['inputUser'];
$senhausuario = $_POST['inputPassword'];

$conectou  = 0;
include 'conexao.php';

if($conectou){
    $sql = "SELECT * FROM usuarios WHERE nome_usuario = '$usuario' and senha = '$senhausuario'";

    $buscar = mysqli_query($conec, $sql);
    $totalUsuarios = mysqli_num_rows($buscar); 

    if($totalUsuarios > 0){
        $dados = mysqli_fetch_array($buscar);
        if($dados){
            session_start();
            $_SESSION['usuario'] = $dados['nome_usuario'];
            $_SESSION['permissao'] = $dados['permissao'];
            header("location: menu.php");
        }
    }else{
        echo ("<script>alert('Erro nos dados do Usuário');<script>");
        echo ("<meta HTTP-EQUIV= 'Refresh' target='_blank' CONTENT='0;URL=index.php'>");
    }
}
?>
