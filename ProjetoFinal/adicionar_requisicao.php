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
    <title>Cadastro de Requisição</title>
</head>

<body>
    <div class="container" style="margin-top: 40px; width: 500px;">
        <h3 class="text-center">Nova Requisição / Solicitação</h3>
        <form name="formulario" action="inserir_requisicao.php" method="post">
            <div class="form-group">
                <label for="cod_produto">Código item</label>
                <select name="cod_produto" id="cod_produto" class="form-control" required>
                    <option value="">Selecione um produto</option>
                    <?php
                    include "conexao.php";

                    $sql = "SELECT codigo, produto, saldo, preco_compra FROM produto";
                    $busca = mysqli_query($conec, $sql);

                    $produtos_js = [];
                    $saldos_js = [];

                    while ($array = mysqli_fetch_array($busca)) {
                        $codigo = $array['codigo'];
                        $produto = $array['produto'];
                        $saldo = $array['saldo'];
                        $preco_compra = $array['preco_compra'];

                        $produtos_js[$codigo] = $produto;
                        $saldos_js[$codigo] = $saldo;
                        $precos_js[$codigo] = $preco_compra;

                        echo "<option value='$codigo'>$produto</option>";
                    }
                    ?>
                </select>

                <label for="produto">Produto</label>
                <input type="text" class="form-control" id="produto" name="produto" readonly>

                <label for="qtde">Quantidade</label>
                <input type="number" class="form-control" id="qtde" name="qtde" placeholder="Informe a quantidade" min="1" required>

                <label for="saldo">Saldo</label>
                <input type="number" class="form-control" id="saldo" name="saldo" readonly>

                <label for="preco_compra">Preço de Compra</label>
                <input type="hidden" id="preco_compra" name="preco_compra">

                <label for="valor">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" readonly>

                <div class="form-group">
                    <label for="tipo">Tipo de Compra (RM/SC)</label><br>
                    <input type="radio" id="rm" name="tipo" value="RM">
                    <label for="rm">RM</label><br>
                    <input type="radio" id="sc" name="tipo" value="SC">
                    <label for="sc">SC</label><br><br>
                </div>
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

        <script>
            var produtos = <?php echo json_encode($produtos_js); ?>;
            var saldos = <?php echo json_encode($saldos_js); ?>;
            var precosCompra = <?php echo json_encode($precos_js); ?>;

            $(document).ready(function () {
                $("#cod_produto").change(function () {
                    var codigoSelecionado = $(this).val();
                    $("#produto").val(produtos[codigoSelecionado] || ""); 
                    $("#saldo").val(saldos[codigoSelecionado] || ""); 
                    $("#preco_compra").val(precosCompra[codigoSelecionado] || ""); 
                    calcularValor();  
                });

                $("#qtde").on('input', function () {
                    calcularValor();  
                });

                function calcularValor() {
                    var precoCompra = parseFloat($("#preco_compra").val());
                    var qtde = parseInt($("#qtde").val());

                    if (!isNaN(precoCompra) && !isNaN(qtde)) {
                        var valorTotal = precoCompra * qtde;
                        $("#valor").val(valorTotal.toFixed(2));  
                    } else {
                        $("#valor").val('');  
                    }
                }
            });
        </script>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
</body>

</html>
