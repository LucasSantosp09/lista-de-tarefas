<?php
@session_start();
require("conexao.php");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];


$query = $pdo->prepare("SELECT * from usuarios where usuario = :usuario and senha = :senha");
$query->bindValue(":usuario", "$usuario");
$query->bindValue(":senha", "$senha");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);


$_SESSION['id_usuario'] = $res[0]['id'];





$total_reg = @count($res);
if($total_reg > 0){
	$ativo = $res[0]['ativo'];



	if($ativo == 'Sim'){
		echo "<script>window.location='painel'</script>";
	}else{
		echo "<script>window.alert('Seu usuário foi desativado, contate o administrador!')</script>";
	    echo "<script>window.location='index.php'</script>";
	}
	
}else{
	echo "<script>window.alert('Usuário ou Senha Incorretos!')</script>";
	echo "<script>window.location='index.php'</script>";
}

?>