<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

include 'conexao.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    echo "<script>alert('ID inválido!'); window.location.href = 'listar_fornecedores.php';</script>";
    exit;
}

$sql = "SELECT * FROM fornecedor WHERE id_fornecedor = $id";
$buscar = mysqli_query($conec, $sql);
$array = mysqli_fetch_array($buscar);

if (!$array) {
    echo "<script>alert('Fornecedor não encontrado!'); window.location.href = 'listar_fornecedores.php';</script>";
    exit;
}

$id_fornecedor = $array['id_fornecedor'];
$nome_fornecedor = htmlspecialchars($array['nome_fornecedor']);
$email_fornecedor = htmlspecialchars($array['email_fornecedor']);
$cnpj = htmlspecialchars($array['cnpj']);
$telefone = htmlspecialchars($array['telefone']);
$status = htmlspecialchars($array['status']);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Fornecedor</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 40px; max-width: 500px;">
        <div class="text-center">
            <h3>Editar Fornecedor</h3>
        </div>
        
        <form action="atualizar_fornecedor.php" method="post" style="margin-top: 20px">
            <input type="hidden" name="id_fornecedor" value="<?php echo $id_fornecedor; ?>">

            <div class="form-group">
                <label>Nome de Fornecedor</label>
                <input type="text" class="form-control" name="nome_fornecedor" value="<?php echo $nome_fornecedor; ?>" required>
                <label>Email</label>
                <input type="text" class="form-control" name="email_fornecedor" value="<?php echo $email_fornecedor; ?>" required>
                <label>CNPJ</label>
                <input type="text" class="form-control" name="cnpj" value="<?php echo $cnpj; ?>" required>
                <label>Telefone</label>
                <input type="text" class="form-control" name="telefone" value="<?php echo $telefone; ?>" required>
                
            </div>

            <label>Status</label>
            <select class="form-control" name="status" required>
                <?php foreach (["ativo" => "Ativo", "inativo" => "Inativo"] as $key => $label): ?>
                    <option value="<?= $key ?>" <?= ($status == $key) ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>

            <div class="text-right">
                <button type="submit" class="btn btn-warning btn-sm">Atualizar</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
