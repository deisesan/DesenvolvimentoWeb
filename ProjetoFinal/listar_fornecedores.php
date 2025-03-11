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
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Fornecedores</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
</head>

<body>
    <div class="container" style="margin-top: 40px">
        <h3>Lista de Fornecedores</h3>

        <div style="text-align: right; margin-bottom: 20px;">
            <a href="adicionar_fornecedores.php" role="button" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Cadastrar Fornecedor
            </a>
        </div>

        <table id="table_id" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nome do Fornecedor</th>
                    <th scope="col">Email</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">Telefone</th>
                    <th scope="col" style="text-align: center;">Status</th>
                    <th scope="col" style="text-align: center;">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "conexao.php";

                $sql = "SELECT id_fornecedor, nome_fornecedor, email_fornecedor, cnpj, telefone, status FROM fornecedor";
                $busca = mysqli_query($conec, $sql);

                while ($array = mysqli_fetch_array($busca)) {
                    $id_fornecedor = $array['id_fornecedor'];
                    $nome_fornecedor = htmlspecialchars($array['nome_fornecedor']);
                    $email_fornecedor = htmlspecialchars($array['email_fornecedor']);
                    $cnpj = htmlspecialchars($array['cnpj']);
                    $telefone = htmlspecialchars($array['telefone']);
                    $status = htmlspecialchars($array['status']);
                ?>
                    <tr>
                        <td><?php echo $nome_fornecedor; ?></td>
                        <td><?php echo $email_fornecedor; ?></td>
                        <td><?php echo $cnpj; ?></td>
                        <td><?php echo $telefone; ?></td>
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
                            <a href="editar_fornecedor.php?id=<?php echo urlencode($id_fornecedor); ?>">
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
                pageLength: 10,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>

</body>

</html>