<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

include 'conexao.php';

// verifica se o ID do produto foi enviado
if (isset($_POST['id_estoque'])) {
    $id_estoque = $_POST['id_estoque'];
    $codigo = $_POST['codigo'];
    $produto_nome = $_POST['produto'];
    $saldo = $_POST['saldo'];
    $tipo = $_POST['tipo'];
    $preco_compra = $_POST['preco_compra'];
    $dt_cadastro = $_POST['dt_cadastro'];
    $categoria = $_POST['categoria'];
    $fornecedor = $_POST['fornecedor'];
    $status = $_POST['status']; 

    if ($status !== 'ativo' && $status !== 'inativo') {
        $_SESSION['erro'] = "Valor inválido para o campo 'status'!";
        header('Location: listar_produtos.php');
        exit;
    }

    $sql = "UPDATE produto SET 
                codigo = '$codigo', 
                produto = '$produto_nome', 
                saldo = '$saldo', 
                tipo = '$tipo', 
                preco_compra = '$preco_compra', 
                dt_cadastro = '$dt_cadastro', 
                categoria_id_categoria = '$categoria', 
                fornecedor_id_fornecedor = '$fornecedor', 
                status = '$status' 
            WHERE id_estoque = $id_estoque";

    if (mysqli_query($conec, $sql)) {
        $_SESSION['sucesso'] = "Produto atualizado com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao atualizar produto: " . mysqli_error($conec);
    }

} else {
    $_SESSION['erro'] = "ID do produto não encontrado!";
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Atualização de Produto</title>
</head>

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
        <?php if (isset($_SESSION['sucesso'])): ?>
            <div id="erro" class="alert alert-success alert-dismissible fade show">
                <?php echo $_SESSION['sucesso']; ?>
            </div>
            <?php unset($_SESSION['sucesso']); ?>
        <?php elseif (isset($_SESSION['erro'])): ?>
            <div id="erro" class="alert alert-danger alert-dismissible fade show">
                <?php echo $_SESSION['erro']; ?>
            </div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
</body>

</html>
