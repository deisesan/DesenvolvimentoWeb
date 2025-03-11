<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Categorias</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
</head>

<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['debug_status'])) {
    echo "<div class='alert alert-info'>" . $_SESSION['debug_status'] . "</div>";
    unset($_SESSION['debug_status']); 
}


if (isset($_SESSION['sucesso'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['sucesso'] . "</div>";
    unset($_SESSION['sucesso']);
}

if (isset($_SESSION['erro'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['erro'] . "</div>";
    unset($_SESSION['erro']);
}
?>

<body>
    <div class="container" style="margin-top: 40px">
        <h3>Lista de Produtos</h3>

        <div style="text-align: right; margin-bottom: 20px;">
            <a href="adicionar_produtos.php" role="button" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Cadastrar Produto
            </a>
        </div>

        <table id="table_id" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Saldo</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Data de cadastro</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Fornecedor</th>
                    <th scope="col">Status</th>
                    <th scope="col" style="text-align: center;">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "conexao.php";

                $sql = "SELECT p.id_estoque, p.codigo, p.produto, p.saldo, p.status, p.tipo, 
                               p.preco_compra, p.dt_cadastro, c.categoria, f.nome_fornecedor  
                        FROM produto p
                        JOIN categoria c ON p.categoria_id_categoria = c.id_categoria
                        JOIN fornecedor f ON p.fornecedor_id_fornecedor = f.id_fornecedor";

                $busca = mysqli_query($conec, $sql);

                while ($array = mysqli_fetch_array($busca)) {
                    $id_estoque = htmlspecialchars($array['id_estoque']);
                    $codigo = htmlspecialchars($array['codigo']);
                    $produto = htmlspecialchars($array['produto']);
                    $saldo = htmlspecialchars($array['saldo']);
                    $status = htmlspecialchars($array['status']);
                    $tipo = htmlspecialchars($array['tipo']);
                    $preco_compra = htmlspecialchars($array['preco_compra']);
                    $dt_cadastro = date('d/m/Y', strtotime($array['dt_cadastro']));
                    $categoria = htmlspecialchars($array['categoria']);
                    $fornecedor = htmlspecialchars($array['nome_fornecedor']);
                ?>
                    <tr>
                        <td style="vertical-align: inherit;"> <?php echo $codigo; ?> </td>
                        <td style="vertical-align: inherit;"> <?php echo $produto; ?> </td>
                        <td style="vertical-align: inherit; text-align: right;"> <?php echo $saldo; ?> </td>
                        <td style="vertical-align: inherit;"> <?php echo $tipo; ?> </td>
                        <td style="vertical-align: inherit; text-align: right;"> <?php echo $preco_compra; ?> </td>
                        <td style="vertical-align: inherit;"> <?php echo $dt_cadastro; ?> </td>
                        <td style="vertical-align: inherit;"> <?php echo $categoria; ?> </td>
                        <td style="vertical-align: inherit;"> <?php echo $fornecedor; ?> </td>
                        <td style="text-align: center;">
                            <?php
                            if (strtolower($status) == "inativo") {
                                echo "<span style='color: red; font-weight: bold;'>" . strtoupper($status) . "</span>";
                            } else {
                                echo "<span style='color: green; font-weight: bold;'>" . strtoupper($status) . "</span>";
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <a href="editar_produto.php?id=<?php echo urlencode($id_estoque); ?>">
                                <button type="button" class="btn btn-warning btn-sm">
                                    <i class="far fa-edit"></i> 
                                </button>
                            </a>
                            <a href="excluir_produto.php?id=<?php echo urlencode($id_estoque); ?>">
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="far fa-trash-alt"></i> 
                                </button>
                            </a>
                        </td>


                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                pageLength: 10,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>

</body>

</html>