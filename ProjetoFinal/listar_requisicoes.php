<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Requisições</title>

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
</head>
<style>
    .fonte {
        font-size: 14px;
    }
</style>
<?php
session_start();
$usuario = $_SESSION['usuario'];
$permissao = $_SESSION['permissao'];
if (!isset($_SESSION['usuario'])) {
    header('Location: logoff.php');
}
?>

<body>
    <div style="margin-top: 40px">
        <h3>Liberação de Requisições/Solicitações</h3>
        <div style="text-align: right; margin-top:20px;">
            <a href="adicionar_requisicao.php">
                <button type="button" class="btn btn-success btn-sm"><i class="far fa-edit"></i>&nbsp;Nova Solicitação</button>
            </a>
        </div>
        <br>
        <table id="table_id" class="table">
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">QTDE</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data solicitação</th>

                    <th scope="col">Tipo</th>
                    <th scope="col">Solicitante</th>
                    <th scope="col">Situação</th>
                </tr>
            </thead>
            <?php
            include 'conexao.php';
            $sql = "SELECT * FROM requisicao";
            $busca = mysqli_query($conec, $sql);
            while ($array = mysqli_fetch_array($busca)) {
                $qtde = $array['qtde'];
                $idrm = $array['idrm'];
                $produto = $array['produto'];
                $valor = $array['valor'];
                $data = $array['dt_rm'];
                $tipo = $array['tipo'];
                $solicitante = $array['user_requisicao'];
                $situacao = $array['situacao'];
                $bg = '#ffae00';
                $botao = "btn btn-warning";
                $status = "enabled";
                switch ($situacao) {
                    case "Aprovada":
                        $botao = "btn btn-success";
                        $bg = '#34eb52';
                        $status = "disabled";
                        break;
                    case "Reprovada":
                        $botao = "btn btn-danger";
                        $bg = '#eb5334';
                        $status = "disabled";
                        break;
                }
            ?>
                <tr class="fonte" style="background-color: <?php echo $bg; ?>;">
                    <td width="30%"><?php echo $produto; ?></td>
                    <td><?php echo $qtde; ?></td>
                    <td><?php echo $valor; ?></td>
                    <td width="10%"><?php echo date('d/m/Y', strtotime($data)); ?></td>
                    <td><?php echo $tipo; ?></td>
                    <td><?php echo $solicitante; ?></td>
                    <td>
                        <button
                            <?php echo $status; ?>
                            style="width: 140px;"
                            type="button"
                            class="<?php echo $botao; ?>"
                            data-toggle="modal"
                            data-target="#confSalvar"
                            onclick="setaDadosModal(<?php echo $idrm; ?>)">
                            <?php echo $situacao; ?>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script src="https://kit.fontawesome.com/cae6919cdb.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                "language": {
                    "lengthMenu": "Mostrando _MENU_ registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro encontrado",
                    "infoFiltered": "(Filtrado de _MAX_ registros totais)",
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeira",
                        "last": "&Uacute;ltima",
                        "next": "Pr&oacute;xima",
                        "previous": "Anterior"
                    },
                    "infoFiltered": "(Filtrado de _MAX_ registros no total)"
                }
            });
        });
    </script>

    <script>
        function setaDadosModal(idrm) {
            document.getElementById('idrm').value = idrm;
            document.getElementById('situacao').value = "";
            document.getElementById('justificativa').value = "";
        }
    </script>

    <div class="modal fade" id="confSalvar" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: right;">Alterar situação</h4>
                </div>
                <div class="modal-body">
                    <p>Situação SC</p>
                    <div class="panel-body">
                        <form id="formModal" method="post" action="atualiza_status.php">
                            <input type="hidden" name="idrm" id="idrm">
                            <select class="form-control" name="situacao" id="situacao" autofocus>
                                <option value="Aprovada">Aprovado</option>
                                <option value="Reprovada">Reprovado</option>
                            </select>

                            <label for="justificativa" style="padding-top:20px;">Justificativa</label>
                            <textarea class="form-control" name="justificativa" id="justificativa" required></textarea>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitForm();" class="btn btn-success">OK</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitForm() {
            document.getElementById('formModal').submit();
            
            setTimeout(function() {
                $('#confSalvar').modal('hide');
            }, 100); 
        }

        function setaDadosModal(idrm) {
            document.getElementById('idrm').value = idrm; 
            document.getElementById('situacao').value = ""; 
            document.getElementById('justificativa').value = ""; 
        }
    </script>
</body>

</html>