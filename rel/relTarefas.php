<?php
require_once('../conexao.php');


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));



$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$status = $_GET['status'];
$usu = $_GET['usu'];
$ordenacao = $_GET['ordenacao'];
$status_like = '%' . $status . '%';

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

if ($status == 'Concluídas') {
	$status_serv = 'Concluídas ';
} else if ($status == 'Pendentes') {
	$status_serv = 'Pendentes';
} else {
	$status_serv = '';
}


if ($dataInicial != $dataFinal) {
	$apuracao = $dataInicialF . ' até ' . $dataFinalF;
} else {
	$apuracao = $dataInicialF;
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>Relatório de Tarefas</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>
		@page {
			margin: 0px;

		}

		.footer {
			margin-top: 20px;
			width: 100%;
			background-color: #ebebeb;
			padding: 10px;
			position: absolute;
			bottom: 0;
		}

		.cabecalho {
			background-color: #ebebeb;
			padding: 10px;
			margin-bottom: 30px;
			width: 100%;
			height: 100px;
		}

		.titulo {
			margin-top: 25px;
			font-size: 28px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;
			padding: 20px;

		}

		.subtitulo {
			margin: 0;
			font-size: 12px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;
		}

		.areaTotais {
			border: 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right: 25px;
			margin-left: 25px;
			position: absolute;
			right: 20;
		}

		.areaTotal {
			border: 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right: 25px;
			margin-left: 25px;
			background-color: #f9f9f9;
			margin-top: 2px;
		}

		.pgto {
			margin: 1px;
		}

		.fonte13 {
			font-size: 13px;
		}

		.esquerda {
			display: inline;
			width: 60%;
			float: left;
		}

		.direita {
			display: inline;
			width: 40%;
			float: right;
			margin-left: 35px;
		}

		.table {
			padding: 15px;
			font-family: Verdana, sans-serif;
			margin-top: 20px;
		}

		.texto-tabela {
			font-size: 12px;
		}


		.esquerda_float {

			margin-bottom: 10px;
			float: left;
			display: inline;
		}


		.titulos {
			margin-top: 10px;
		}

		.image {
			margin-top: -10px;
		}

		.margem-direita {
			margin-right: 80px;
		}

		.margem-direita50 {
			margin-right: 50px;
		}

		hr {
			margin: 8px;
			padding: 1px;
		}


		.titulorel {
			margin: 10px;
			padding: 30px;
			font-size: 25px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;

		}

		.margem-superior {
			margin-top: 30px;
		}

		.areaSubtituloCab {
			margin-top: 15px;
			margin-bottom: 15px;
		}
	</style>


</head>

<body>

	<div class="container">
		<div align="center" class="titulo">
			<span class="titulorel">Relatório de Tarefas <?php echo $status ?> </span>
		</div>


		<hr>
		<table class='table' width='100%' cellspacing='0' cellpadding='3'>
			<tr bgcolor='#f9f9f9'>
				<th>Tarefa</th>
				<th>Data</th>
				<th>Situção</th>


			</tr>
			<?php
			$query = $pdo->query("SELECT * FROM tarefas where data >= '$dataInicial' and data <= '$dataFinal' and situacao LIKE '$status_like' and id_usuario = '$usu' order by $ordenacao");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			$totalItens = @count($res);
			for ($i = 0; $i < @count($res); $i++) {
				foreach ($res[$i] as $key => $value) {
				}
				$nome = $res[$i]['nome'];
				$data = $res[$i]['data'];
				$data_tarefa_formatada = implode('/', array_reverse(explode('-', $res[$i]['data'])));;
				$situacao = $res[$i]['situacao'];

				$query_usu = $pdo->query("SELECT * FROM usuarios where id = '$usu'");
				$res_usu = $query_usu->fetchAll(PDO::FETCH_ASSOC);
				$nome_usu = $res_usu[0]['usuario'];


				if ($situacao == 'Concluída') {
					$classe_linha = 'text-success';
				} else {
					$classe_linha = 'text-danger';
				}
			?>

				<tr class="<?php echo $classe_linha  ?>">
					<td><?php echo $nome ?> </td>
					<td><?php echo $data_tarefa_formatada ?> </td>
					<td><?php echo $situacao ?> </td>
				</tr>
			<?php } ?>




		</table>
		<div class="row">
			<div class="col-sm-6 esquerda">
				<span class=""> <b> Período: </b> </span>

				<span class=""> <?php echo $apuracao ?> </span>

				<span class=""> <b> Quantidade: </b> </span>

				<span class=""> <?php echo $totalItens ?> </span>


			</div>
			<div class="col-sm-6 direita">
				<span class=""> <b> Usuário: </b> </span>
				<span class=""> <?php echo $nome_usu?> </span>
			</div>
		</div>
	</div>
</body>

</html>