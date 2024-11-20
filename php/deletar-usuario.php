<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

function deletar_usuario($conn,$usuario){
	$query = 'delete from usuarios where usuario="'.$usuario.'";';
	$result_query = mysqli_query($conn,$query);

	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao deletar usuário!"}');
	}else{
		die('{"sucesso":1,"msg":"Usuário deletado com sucesso!"}');
	}
}

if (isset($_POST["usuario"])){
	$usuario = $_POST["usuario"];
	deletar_usuario($conn,$usuario);
}
?>