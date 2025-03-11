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
    <title>Cadastro de Produtos</title>
</head>

<body>
    <div class="container" style="margin-top: 40px; width: 500px;">
        <h3 class="text-center">Cadastrar Produto</h3>
        <form name="formulario" action="inserir_produtos.php" method="post">
            <div class="form-group">

                <label for="nome_produto">Nome:</label>
                <input type="text" class="form-control" id="nome_produto" name="nome_produto" placeholder="Digite o nome do produto" required>

                <label for="saldo">Saldo:</label>
                <input type="number" class="form-control" id="saldo" name="saldo" placeholder="Informe saldo" min="0" required>

                <label for="tipo">Tipo:</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="">Selecione um tipo</option>
                    <option value="nacional">Nacional</option>
                    <option value="importado">Importado</option>
                </select>

                <label for="preco">Preço:</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" placeholder="Digite o preço" min="0" required>

                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" class="form-control" required>
                    <option value="">Selecione uma categoria</option>
                    <?php
                    include "conexao.php";

                    $sql = "SELECT id_categoria, categoria FROM categoria WHERE status = 'ativo'";
                    $busca = mysqli_query($conec, $sql);

                    while ($array = mysqli_fetch_array($busca)) {
                        $id_categoria = $array['id_categoria'];
                        $categoria = htmlspecialchars($array['categoria']);
                        echo "<option value='$id_categoria'>$categoria</option>";
                    }
                    ?>
                </select>

                <label for="fornecedor">Fornecedor:</label>
                <select name="fornecedor" id="fornecedor" class="form-control" required>
                    <option value="">Selecione um fornecedor</option>
                    <?php
                    include "conexao.php";

                    $sql = "SELECT id_fornecedor, nome_fornecedor FROM fornecedor WHERE status = 'ativo'";
                    $busca = mysqli_query($conec, $sql);

                    while ($array = mysqli_fetch_array($busca)) {
                        $id_fornecedor = $array['id_fornecedor'];
                        $nome_fornecedor = htmlspecialchars($array['nome_fornecedor']);
                        echo "<option value='$id_fornecedor'>$nome_fornecedor</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">
                    Cadastrar
                </button>
            </div>
        </form>


        <div class="modal fade" id="confSalvar" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmar</h4>
                    </div>
                    <div class="modal-body">
                        <p>Confirma o cadastro?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="document.formulario.submit();" class="btn btn-success" data-dismiss="modal">OK</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
</body>

</html>