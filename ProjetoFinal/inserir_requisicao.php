<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

include 'conexao.php';

$idProduto = isset($_POST['cod_produto']) ? mysqli_real_escape_string($conec, $_POST['cod_produto']) : null;
$produto = isset($_POST['produto']) ? mysqli_real_escape_string($conec, $_POST['produto']) : null;
$qtde = isset($_POST['qtde']) ? mysqli_real_escape_string($conec, $_POST['qtde']) : null;
$tipo = isset($_POST['tipo']) ? mysqli_real_escape_string($conec, $_POST['tipo']) : null;
$saldo = isset($_POST['saldo']) ? mysqli_real_escape_string($conec, $_POST['saldo']) : null;
$precoCompra = isset($_POST['preco_compra']) ? mysqli_real_escape_string($conec, $_POST['preco_compra']) : null;
$usuario = $_SESSION['usuario'];
$data_solicitacao = date('Y-m-d');
$situacao = 'Pendente';
$valorTotal = number_format($precoCompra * $qtde, 2, '.', '');

if (!$idProduto || !$qtde || !$tipo) {
    die("Erro: Todos os campos devem ser preenchidos.");
}

$sql = "INSERT INTO requisicao (cod_produto, produto, qtde, tipo, user_requisicao, dt_status, situacao, valor) 
        VALUES ('$idProduto', '$produto', '$qtde - $saldo', '$tipo', '$usuario', '$data_solicitacao', '$situacao', '$valorTotal')";

if (mysqli_query($conec, $sql)) {
    echo "Requisição cadastrada com sucesso!";
} else {
    echo "Erro ao cadastrar requisição: " . mysqli_error($conec);
}

mysqli_close($conec);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Cadastro de Requisição</title>
</head>

<body>
    <script>
        setTimeout(function() {
            history.go(-2);
        }, 1000);
    </script>
    <div class="container">
        <div id="erro" class="alert alert-info">
            Requisição salva com sucesso!
        </div>
    </div>
</body>

</html>