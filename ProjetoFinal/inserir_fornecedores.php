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
    <title>Cadastro de Forcedores</title>
</head>
<?php
include 'conexao.php';

$nome_fornecedor = $_POST['nome_fornecedor'];
$email_fornecedor = $_POST['email_fornecedor'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];

$sql = "INSERT INTO fornecedor (nome_fornecedor, email_fornecedor, cnpj, telefone) VALUES ('$nome_fornecedor', '$email_fornecedor', '$cnpj', '$telefone')";
mysqli_query($conec, $sql);

?>

<body>
    <script>
        setTimeout(function() {
            // document.getElementById("erro").style.display = "none";
            history.go(-2);

        }, 1000);

        function hide() {
            document.getElementById("erro").style.display = "none";
        }
    </script>
    <div class="conteiner">
        <div id="erro" class="alert alert-info">
            Registro salvo com sucesso!
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
</body>

</html>