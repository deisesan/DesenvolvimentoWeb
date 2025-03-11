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
    <title>Cadastro de Fornecedores</title>
</head>
<script>
    $(document).ready(function() {
        $('#telefone').mask('(00) 00000-0000');
        $('#cnpj').mask('00.000.000/0000-00');
    });

    function validarEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function validarTelefone(telefone) {
        const regex = /^\(\d{2}\) \d{4,5}-\d{4}$/;
        return regex.test(telefone);
    }


    function validarCNPJ(cnpj) {
        const regex = /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/;
        return regex.test(cnpj);
    }

    function validarFormulario() {

        const nome = document.getElementById('nome_fornecedor').value.trim();
        const email = document.getElementById('email_fornecedor').value.trim();
        const telefone = document.getElementById('telefone').value.trim();
        const cnpj = document.getElementById('cnpj').value.trim();

        if (nome === "") {
            alert("Por favor, preencha o nome do fornecedor.");
            return false;
        }

        if (!validarEmail(email)) {
            alert("Por favor, insira um email válido.\nExemplo: exemplo@dominio.com");
            return false;
        }

        if (!validarCNPJ(cnpj)) {
            alert("Por favor, insira um CNPJ válido.\nExemplo: 00.000.000/0000-00");
            return false;
        }

        if (!validarTelefone(telefone)) {
            alert("Por favor, insira um telefone válido.\nFormatos aceitos: (11) 1234-5678 ou (11) 91234-5678");
            return false;
        }

        $('#confSalvar').modal('show');
        return false;
    }

    function confirmarCadastro() {
        document.getElementById("formulario").submit();
    }
</script>

<body>
    <div class="container" style="margin-top: 40px; width: 500px;">
        <h3 class="text-center">Cadastrar Fornecedor</h3>
        <form name="formulario" action="inserir_fornecedores.php" method="post">
            <div class="form-group">
                <label for="nome_fornecedor">Nome:</label>
                <input type="text" class="form-control" id="nome_fornecedor" name="nome_fornecedor" placeholder="Digite o nome do fornecedor" required>

                <label for="email_fornecedor">Email:</label>
                <input type="email" class="form-control" id="email_fornecedor" name="email_fornecedor" placeholder="Digite o email do fornecedor" required>

                <label for="cnpj">CNPJ:</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o CNPJ do fornecedor" required>

                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o telefone do fornecedor" required>
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