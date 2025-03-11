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

<body>
    <div class="container" style="margin-top: 40px; width: 500px;">
        <h3 class="text-center">Cadastrar Categoria</h3>
        <form name="formulario" action="inserir_categorias.php" method="post">
            <div class="form-group">
                <label for="categoria">Nome da Categoria:</label>
                <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Digite o nome da categoria">
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confSalvar">
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
