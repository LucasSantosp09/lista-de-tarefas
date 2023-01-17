<?php
require('../../conexao.php');

$tabela = 'tarefas';

$id = $_POST['id'];

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");

echo 'Excluído com Sucesso!';

?>