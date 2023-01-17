<?php
@session_start();
$pag = 'tarefas';

require_once('../conexao.php');
$id_usuario =  $_SESSION['id_usuario'];

//RECUPERAR DADOS DO USUÁRIO
$query = $pdo->query("SELECT * from usuarios WHERE id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = $res[0]['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../vendor/DataTables/datatables.min.css">

    <script type="text/javascript" src="../vendor/DataTables/datatables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <title>Lista de Tarefas</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="index.php">Lista de Tarefas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                </ul>
                <div class="d-flex mx-3">
                    <img src="../img/icone-user.png" width="40px" height="40px">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $nome_usu ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" href="../logout.php">Sair</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div>
        <a href="index.php?funcao=novo" type="button" class="btn btn-primary mt-5 mx-3">Nova Tarefa</a>
        <a href="index.php?funcao=relatorio" type="button" class="btn btn-secondary mt-5"><i class="bi bi-printer text-light" title="Imprimir"></i></a>
    </div>

    <div class="mt-4 mx-4" style="margin-right:25px">

        <table id="example" class="table table-hover my-4" style="width:100%">
            <?php
            $query = $pdo->query("SELECT * from tarefas where id_usuario = '$id_usuario' order by nome desc");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res);
            if ($total_reg > 0) {
            ?>
                <thead>
                    <tr>
                        <th>Tarefa</th>
                        <th>Situação</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < $total_reg; $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }
                        $data_tarefa_formatada = implode('/', array_reverse(explode('-', $res[$i]['data'])));;
                        $situacao = $res[$i]['situacao'];
                        if ($situacao == 'Concluída') {
                            $classe_linha = 'text-success';
                        } else {
                            $classe_linha = 'text-danger';
                        }

                    ?>

                        <tr class="<?php echo $classe_linha ?>">
                            <td><?php echo $res[$i]['nome'] ?></td>
                            <td><?php echo $res[$i]['situacao'] ?></td>
                            <td><?php echo $data_tarefa_formatada ?></td>
                            <td>
                                <a href="index.php?funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro" style="text-decoration: none">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </a>

                                <a href="index.php?funcao=excluir&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro" style="text-decoration: none">
                                    <i class="bi bi-trash text-danger mx-1"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

        </table>
    <?php } else {
                echo '<p>Não existem dados para serem exibidos!!';
            } ?>
    </div>
</body>

</html>


<?php
if (@$_GET['funcao'] == "editar") {
    $titulo_modal = 'Editar Registro';
    $query = $pdo->query("SELECT * from tarefas where id = '$_GET[id]'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) {
        $nome = $res[0]['nome'];
        $data_tarefa = $res[0]['data'];
        $situacao = $res[0]['situacao'];
    }
} else {
    $titulo_modal = 'Inserir Registro';
}
?>


<div class="modal fade" tabindex="-1" id="modalCadastrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-salvar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required value="<?php echo @$nome ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 mt-1">
                                <label for="exampleFormControlInput1" class="form-label">Data</label>
                                <input type="date" class="form-control" id="data_tarefa" name="data_tarefa" required="" value="<?php echo @$data_tarefa ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Situação</label>
                                <select class="form-select mt-1" aria-label="Default select example" id="situacao" name="situacao">

                                    <option <?php if (@$situacao == 'Pendente') { ?> selected <?php } ?> value="Pendente">Pendente</option>

                                    <option <?php if (@$situacao == 'Concluída') { ?> selected <?php } ?> value="Concluída">Concluída</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario ?>">

                    <small>
                        <div align="center" class="mt-1" id="mensagem-salvar">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modalDeletar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-excluir">
                <div class="modal-body">

                    <p>Deseja Realmente Excluir o Registro?</p>

                    <small>
                        <div align="center" class="mt-1" id="mensagem-excluir">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalRelatorio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relatório de Tarefas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../rel/relTarefas_class.php" method="POST" target="_blank">   
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Data Inicial</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1" name="dataInicial">
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>Data Final</label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control mt-1" name="dataFinal">
                        </div>


                    </div>

                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>Tarefa</label>
                            <select class="form-select mt-1" name="status">
                                <option value="">Todas</option>
                                <option value="Pendente">Pendentes</option>
                                <option value="Concluída">Concluídas</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>Ordenar</label>
                            <select class="form-select mt-1" name="ordenacao">
                                <option value="data">Data</option>
                                <option value="nome">Tarefa</option>
                                <option value="situacao">Situação</option>

                            </select>
                        </div>
                    </div>


                 

                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                <input type="hidden" name="usu" id="usu" value="<?php echo $id_usuario ?>">
            </div>
        </div>
             
        </form>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            "ordering": true
        });
    });
</script>


<?php
if (@$_GET['funcao'] == "novo") { ?>
    <script type="text/javascript">
        2
        var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
            backdrop: 'static'
        })

        myModal.show();
    </script>
<?php } ?>

<?php
if (@$_GET['funcao'] == "relatorio") { ?>
    <script type="text/javascript">
        2
        var myModal = new bootstrap.Modal(document.getElementById('modalRelatorio'), {
            backdrop: 'static'
        })

        myModal.show();
    </script>
<?php } ?>


<?php
if (@$_GET['funcao'] == "editar") { ?>
    <script type="text/javascript">
        2
        var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
            backdrop: 'static'
        })

        myModal.show();
    </script>
<?php } ?>


<?php
if (@$_GET['funcao'] == "excluir") { ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {
            backdrop: 'static'
        })

        myModal.show();
    </script>
<?php } ?>




<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
    $("#form-salvar").submit(function() {
        var pag = "<?= $pag ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Inserido com Sucesso!") {

                    $('#mensagem-salvar').addClass('text-success')

                    $('#btn-fechar').click();
                    window.location = "index.php?pagina=" + pag;

                } else {

                    $('#mensagem-salvar').addClass('text-danger')
                }

                $('#mensagem-salvar').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,

        });
    });
</script>




<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
    $("#form-excluir").submit(function() {
        var pag = "<?= $pag ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/excluir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Excluído com Sucesso!") {

                    $('#mensagem-excluir').addClass('text-success')

                    $('#btn-fechar').click();
                    window.location = "index.php?pagina=" + pag;

                } else {

                    $('#mensagem-excluir').addClass('text-danger')
                }

                $('#mensagem-excluir').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,

        });
    });
</script>