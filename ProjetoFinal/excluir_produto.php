<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Caso não receba um id válido
    header('Location: listar_produtos.php');
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
    <title>Deletar Produto</title>
</head>

<body>
    <div class="container" style="margin-top: 40px; width: 500px;">

        <div class="modal fade" id="confSalvar" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmar</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir este produto?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="deletar_produto.php?id=<?php echo $id; ?>" class="btn btn-success">OK</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href='listar_produtos.php';">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                $('#confSalvar').modal('show');
            });
        </script>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
</body>

</html>