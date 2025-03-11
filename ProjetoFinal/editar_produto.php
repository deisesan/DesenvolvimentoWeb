<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

include 'conexao.php';


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id <= 0) {
    $_SESSION['erro'] = "ID inválido!";
    header('Location: listar_produtos.php');
    exit;
}

$sql = "SELECT p.*, c.id_categoria, f.id_fornecedor 
        FROM produto p
        LEFT JOIN categoria c ON p.categoria_id_categoria = c.id_categoria
        LEFT JOIN fornecedor f ON p.fornecedor_id_fornecedor = f.id_fornecedor
        WHERE p.id_estoque = ?";

$stmt = mysqli_prepare($conec, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produto = mysqli_fetch_assoc($result);

if (!$produto) {
    $_SESSION['erro'] = "Produto não encontrado!";
    header('Location: listar_produtos.php');
    exit;
}

$id_estoque = $produto['id_estoque'];
$codigo = $produto['codigo'];
$produto_nome = $produto['produto'];
$saldo = $produto['saldo'];
$tipo = $produto['tipo'];
$preco_compra = $produto['preco_compra'];
$dt_cadastro = date('Y-m-d', strtotime($produto['dt_cadastro']));
$categoria_atual = $produto['id_categoria'];  // Usar o ID da categoria
$fornecedor_atual = $produto['id_fornecedor']; // Usar o ID do fornecedor
$status = $produto['status'];
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Produto</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container" style="margin-top: 40px; max-width: 500px;">
        <div class="text-center">
            <h3>Editar Produto</h3>
        </div>

        <form action="atualizar_produto.php" method="post">
            <input type="hidden" name="id_estoque" value="<?= htmlspecialchars($id_estoque) ?>">

            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" class="form-control" name="codigo" value="<?= htmlspecialchars($codigo) ?>" required>

                <label for="produto">Nome:</label>
                <input type="text" class="form-control" name="produto" value="<?= htmlspecialchars($produto_nome) ?>" required>

                <label for="saldo">Saldo:</label>
                <input type="number" class="form-control" name="saldo" value="<?= htmlspecialchars($saldo) ?>" min="0" required>

                <label for="tipo">Tipo:</label>
                <select name="tipo" class="form-control" required>
                    <option value="">Selecione um tipo</option>
                    <option value="nacional" <?= $tipo === 'nacional' ? 'selected' : '' ?>>Nacional</option>
                    <option value="importado" <?= $tipo === 'importado' ? 'selected' : '' ?>>Importado</option>
                </select>

                <label for="preco_compra">Preço:</label>
                <input type="number" step="0.01" class="form-control" name="preco_compra" value="<?= htmlspecialchars($preco_compra) ?>" min="0" required>

                <label for="dt_cadastro">Data de Cadastro:</label>
                <input type="date" class="form-control" name="dt_cadastro" value="<?= htmlspecialchars($dt_cadastro) ?>" required>

                <label for="categoria">Categoria:</label>
                <select name="categoria" class="form-control" required>
                    <?php
                    if ($categoria_atual) {
                        // Busca categoria atual
                        $stmt_cat = mysqli_prepare(
                            $conec,
                            "SELECT id_categoria, categoria, status 
                     FROM categoria 
                     WHERE id_categoria = ?"
                        );
                        mysqli_stmt_bind_param($stmt_cat, "i", $categoria_atual);
                        mysqli_stmt_execute($stmt_cat);
                        $cat_atual = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_cat));

                        if ($cat_atual) {
                            echo '<option value="' . htmlspecialchars($cat_atual['id_categoria']) . '" selected>' . htmlspecialchars($cat_atual['categoria']) . '</option>';
                        }

                        mysqli_stmt_close($stmt_cat);
                    }
                    ?>

                    <?php
                    // Busca categorias ativas
                    $sql_cat_ativas = "SELECT id_categoria, categoria 
                               FROM categoria 
                               WHERE status = 'ativo'"
                        . ($categoria_atual ? " AND id_categoria != ?" : "");
                    $stmt_cat_ativas = mysqli_prepare($conec, $sql_cat_ativas);

                    if ($categoria_atual) {
                        mysqli_stmt_bind_param($stmt_cat_ativas, "i", $categoria_atual);
                    }

                    mysqli_stmt_execute($stmt_cat_ativas);
                    $categorias = mysqli_stmt_get_result($stmt_cat_ativas);

                    while ($categoria = mysqli_fetch_assoc($categorias)) {
                        echo '<option value="' . htmlspecialchars($categoria['id_categoria']) . '">'
                            . htmlspecialchars($categoria['categoria'])
                            . '</option>';
                    }
                    mysqli_stmt_close($stmt_cat_ativas);
                    ?>
                </select>

                <label for="fornecedor">Fornecedor:</label>
                <select name="fornecedor" class="form-control" required>
                    <?php
                    if ($fornecedor_atual) {
                        // Busca fornecedor atual
                        $stmt_forn = mysqli_prepare(
                            $conec,
                            "SELECT id_fornecedor, nome_fornecedor, status 
                     FROM fornecedor 
                     WHERE id_fornecedor = ?"
                        );
                        mysqli_stmt_bind_param($stmt_forn, "i", $fornecedor_atual);
                        mysqli_stmt_execute($stmt_forn);
                        $forn_atual = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_forn));

                        if ($forn_atual) {
                            echo '<option value="' . htmlspecialchars($forn_atual['id_fornecedor']) . '" selected>'
                                . htmlspecialchars($forn_atual['nome_fornecedor'])
                                . '</option>';
                        }

                        mysqli_stmt_close($stmt_forn);
                    }
                    ?>

                    <?php
                    // Busca fornecedores ativos
                    $sql_forn_ativos = "SELECT id_fornecedor, nome_fornecedor 
                                FROM fornecedor 
                                WHERE status = 'ativo'"
                        . ($fornecedor_atual ? " AND id_fornecedor != ?" : "");
                    $stmt_forn_ativos = mysqli_prepare($conec, $sql_forn_ativos);

                    if ($fornecedor_atual) {
                        mysqli_stmt_bind_param($stmt_forn_ativos, "i", $fornecedor_atual);
                    }

                    mysqli_stmt_execute($stmt_forn_ativos);
                    $fornecedores = mysqli_stmt_get_result($stmt_forn_ativos);

                    while ($fornecedor = mysqli_fetch_assoc($fornecedores)) {
                        echo '<option value="' . htmlspecialchars($fornecedor['id_fornecedor']) . '">'
                            . htmlspecialchars($fornecedor['nome_fornecedor'])
                            . '</option>';
                    }
                    mysqli_stmt_close($stmt_forn_ativos);
                    ?>
                </select>
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