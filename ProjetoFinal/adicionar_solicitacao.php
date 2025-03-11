<script src="js/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        $("#buscar").click(function() { 
            var codigo = $("#codigo").val();
            if (codigo !== "") { 
                $.ajax({ 
                    url: "busca.php", 
                    type: "POST", 
                    data: {
                        id: codigo
                    }, 
                    dataType: "json", 
                    success: function(response) {
                        if (response.success) {
                            $("#produto").val(response.produto);
                            $("#saldo").val(response.saldo);
                            $("#preco_compra").val(response.preco_compra);
                        } else {
                            alert("Item não encontrado.");
                        }
                    }
                });
            } else {
                alert("Digite um código válido.");
            }
        });
    });
</script>

