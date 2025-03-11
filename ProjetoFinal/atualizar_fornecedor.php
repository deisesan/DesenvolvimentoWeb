<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Atualização de Fornecedor</title>
</head>
<?php
include 'conexao.php';

$id_fornecedor = $_POST['id_fornecedor'];
$nome_fornecedor = $_POST['nome_fornecedor'];
$email_fornecedor = $_POST['email_fornecedor'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];
$status = $_POST['status'];

$sql = "UPDATE fornecedor SET nome_fornecedor='$nome_fornecedor', email_fornecedor='$email_fornecedor', cnpj='$cnpj', telefone='$telefone', status='$status' WHERE id_fornecedor = $id_fornecedor";
mysqli_query($conec, $sql); //envia query para o BD
?>

<body>
    <script>
        setTimeout(function() {
            document.getElementById("erro").style.display = "none";
            history.go(-2);
        }, 100);

        function hide() {
            document.getElementById("erro").style.display = "none";
        }
    </script>
    <div class="container">
        <div id="erro" class="alert alert-info alert-dismissible fade show">
            Registro atualizado com sucesso!
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
</body>

</html>