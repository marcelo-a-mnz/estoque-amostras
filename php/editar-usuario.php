<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

function editar_usuario($conn,$usuario,$nova_senha,$novo_privilegio){
	$query = 'update usuarios set senha="'.$nova_senha.'",privilegio='.$novo_privilegio.' where usuario="'.$usuario.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Ocorreu algum erro ao cadastrar usuário!"}');
	}else{
		die('{"sucesso":1,"msg":"Usuário editado com sucesso!"}');
	}
}

if (isset($_POST["usuario"])){
	$usuario = $_POST["usuario"];
	$nova_senha = $_POST["nova-senha"];
	$novo_privilegio = $_POST["funcao"];
}else{
	die('{"sucesso":0,"msg":"Algo deu errado. Por favor, contate o responsável pelo sistema (Marcelo)!"}');
}

if (pega_privilegio($conn,$_SESSION["usuario"]) != 1){
		die('{"sucesso":0,"msg":"Você não tem permissão para editar usuários. Por favor, solicite para um químico responsável fazer isso."}');
}

if ($usuario == pega_username() and $novo_privilegio != pega_privilegio($conn,$usuario)){
	die('{"sucesso":0,"msg":"Você só pode alterar o cargo de outros usuários!"}');
}

editar_usuario($conn,$usuario,$nova_senha,$novo_privilegio);
?>
