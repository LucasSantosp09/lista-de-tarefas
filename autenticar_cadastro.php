<?php
require('conexao.php');

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$confirma_senha = $_POST['confirma_senha'];

//validar Usuário
$query2 = $pdo->query("SELECT * FROM usuarios where usuario = '$usuario' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if (@count($res2) > 0 ){
    echo "<script>window.alert('Usuário já cadastrado!')</script>";
    echo "<script>window.location='cadastro.php'</script>";
    exit();
}



if ($senha != $confirma_senha ){
    echo "<script>window.alert('Senha não confere!')</script>";
    echo "<script>window.location='cadastro.php'</script>";
}else {
    $res = $pdo->prepare("INSERT INTO usuarios SET usuario = :usuario, senha = :senha, Ativo = 'Sim'");
	$res->bindValue(":usuario", $usuario);
	$res->bindValue(":senha", $senha);
    $res->execute();
   
    echo "<script>window.alert('Cadastrado com Sucesso!')</script>";
    echo "<script>window.location='index.php'</script>";
}

?>