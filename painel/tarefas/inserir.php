<?php

require_once('../../conexao.php');

$id = $_POST['id'];
$nome = $_POST['nome'];
$data_tarefa = $_POST['data_tarefa'];
$situacao = $_POST['situacao'];
$id_usuario = $_POST['id_usuario'];


if ($id == ""){

    $res = $pdo->prepare("INSERT INTO tarefas SET nome = :nome, data = :data_tarefa, situacao = :situacao, id_usuario = :id_usuario");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":data_tarefa", $data_tarefa);
	$res->bindValue(":situacao", $situacao);
	$res->bindValue(":id_usuario", $id_usuario);
    $res->execute();

}else {
	$res = $pdo->prepare("UPDATE tarefas SET nome = :nome, data = :data_tarefa, situacao = :situacao, id_usuario = :id_usuario WHERE id = '$id' ");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":data_tarefa", $data_tarefa);
	$res->bindValue(":situacao", $situacao);
	$res->bindValue(":id_usuario", $id_usuario);
    $res->execute();

}
echo 'Inserido com Sucesso!';


?>