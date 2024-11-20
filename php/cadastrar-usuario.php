<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

//if ($_SESSION["logado"] == 0){
//	die("<html><body><script src='js/sweetalert2.js'></script><script defer>Swal.fire('Por favor, faça login antes de acessar o sistema!').then((result) => { if (result.isConfirmed) { window.location.href = '/logout.php'; } })</script></body></html>");
//}
//if (!usuario_existe($conn,$_SESSION["usuario"])){
//	die("<html><body><script src='js/sweetalert2.js'></script><script defer>Swal.fire('Seu usuário não está mais cadastrado no sistema. Por favor, faça login com outro usuário!').then((result) => { if (result.isConfirmed) { window.location.href = '/logout.php'; } })</script></body></html>");
//}


function cadastrar_usuario($conn,$novo_usuario,$senha,$novo_usuario_privilegio){
	$query = 'insert into usuarios(privilegio,usuario,senha) values("'.$novo_usuario_privilegio.'","'.$novo_usuario.'","'.$senha.'");';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Ocorreu algum erro ao cadastrar usuário!"}');
	}else{
		die('{"sucesso":1,"msg":"Usuário cadastrado com sucesso!"}');
	}
}

if (pega_privilegio($conn,$_SESSION["usuario"]) != 1){
		die('{"sucesso":0,"msg":"Você não tem permissão para cadastrar usuários. Por favor, solicite para um químico responsável fazer isso."}');
}

if (isset($_POST["novo-usuario"])){
	$novo_usuario = $_POST["novo-usuario"];
	$senha = $_POST["senha"];
	$novo_usuario_privilegio = $_POST["funcao"];
}else{
	die('{"sucesso":0,"msg":"Algo deu errado. Por favor, contate o responsável pelo sistema (Marcelo)!"}');
}

if (usuario_existe($conn,$novo_usuario)){
	die('{"sucesso":0,"msg":"Usuário já existe!"}');
}

cadastrar_usuario($conn,$novo_usuario,$senha,$novo_usuario_privilegio);

?>