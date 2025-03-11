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
?>

<body>
    <div class="container" style="margin-top: 40px">
        <h3>Lista de Categorias</h3>

        <div style="text-align: right; margin-bottom: 20px;">
            <a href="adicionar_categorias.php" role="button" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Cadastrar Categoria
            </a>
        </div>

        <table id="table_id" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Descrição da Categoria</th>
                    <th scope="col">Status</th>
                    <th scope="col" style="text-align: center;">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "conexao.php";

                $sql = "SELECT id_categoria, categoria, status FROM categoria";
                $busca = mysqli_query($conec, $sql);

                while ($array = mysqli_fetch_array($busca)) {
                    $id_categoria = $array['id_categoria'];
                    $categoria = htmlspecialchars($array['categoria']);
                    $status = htmlspecialchars($array['status']);

                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categoria); ?></td>
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
                    
                            <a href="editar_categoria.php?id=<?php echo urlencode($id_categoria); ?>">

                                <button type="button" class="btn btn-warning btn-sm">
                                    <i class="far fa-edit"></i> Editar
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
                pageLength: 25,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>

</body>

</html>