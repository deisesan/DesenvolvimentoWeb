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
    <title>Cadastro de Categorias</title>
</head>
<?php
include 'conexao.php';

function gerarCodigoUnico() {

    return mt_rand(100000, 999999);
}

function codigoJaExiste($codigo, $conec) {
    $sql = "SELECT id_estoque FROM produto WHERE codigo = '$codigo'";
    $result = mysqli_query($conec, $sql);
    return mysqli_num_rows($result) > 0; 
}

do {
    $codigo = gerarCodigoUnico();
} while (codigoJaExiste($codigo, $conec)); 

$produto = isset($_POST['nome_produto']) ? mysqli_real_escape_string($conec, $_POST['nome_produto']) : null;
$saldo = isset($_POST['saldo']) ? mysqli_real_escape_string($conec, $_POST['saldo']) : null;
$tipo = isset($_POST['tipo']) ? mysqli_real_escape_string($conec, $_POST['tipo']) : null;
$preco_compra = isset($_POST['preco']) ? mysqli_real_escape_string($conec, $_POST['preco']) : null;
$dt_cadastro = date('Y-m-d'); 
$categoria = isset($_POST['categoria']) ? mysqli_real_escape_string($conec, $_POST['categoria']) : null;
$fornecedor = isset($_POST['fornecedor']) ? mysqli_real_escape_string($conec, $_POST['fornecedor']) : null;
$status = 'ativo';

if (!$produto || !$saldo || !$tipo || !$preco_compra || !$dt_cadastro || !$categoria || !$fornecedor) {
    die("Erro: Todos os campos devem ser preenchidos.");
}

$sql = "INSERT INTO produto (codigo, produto, saldo, tipo, preco_compra, dt_cadastro, categoria_id_categoria, fornecedor_id_fornecedor, status) 
        VALUES ('$codigo', '$produto', '$saldo', '$tipo', '$preco_compra', '$dt_cadastro', '$categoria', '$fornecedor', '$status')";

if (mysqli_query($conec, $sql)) {
    echo "Produto cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar produto: " . mysqli_error($conec);
}

mysqli_close($conec);
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
    <div class="container">
        <div id="erro" class="alert alert-info">
            Registro salvo com sucesso!
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
</body>

</html>
