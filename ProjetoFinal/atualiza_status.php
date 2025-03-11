<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php
include 'conexao.php';
$id = $_POST['idrm'];
$situacao = $_POST['situacao'];
echo "<script>console.log('ID: " . $id . ", Situação: " . $situacao . "');</script>";
$sql = "UPDATE requisicao SET situacao='$situacao' WHERE idrm = $id";
mysqli_query($conec, $sql);
header('Location: listar_requisicoes.php');
?>
</body>

</html>