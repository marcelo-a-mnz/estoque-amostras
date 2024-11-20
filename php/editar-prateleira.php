<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

if (isset($_POST["prateleira"])){
	if (pega_privilegio($conn,$_SESSION["usuario"]) != 1){
		die('{"sucesso":0,"msg":"Você não tem permissão para editar prateleiras. Por favor, solicite para um químico responsável fazer isso."}');
	}
	$prateleira = strtoupper($_POST["prateleira"]);
	$matriz = strtoupper($_POST["matriz"]);
	$validade = $_POST["validade"];
	$capacidade_max = intval($_POST["capacidade-max"]);
	$capacidade_disp_antiga = intval(pega_capacidade_disp($conn,$prateleira));
	$quantidade_na_prateleira = intval(pega_quant_na_prateleira($conn,$prateleira));
	$capacidade_disp_nova = $capacidade_max - $quantidade_na_prateleira;

	if (!prateleira_existe($conn,$prateleira)){
		die('{"sucesso":0,"msg":"Prateleira não existe!"}');
	}
	
	if ($quantidade_na_prateleira > $capacidade_max){
		die('{"sucesso":0,"msg":"A capacidade máxima não pode ser menor que a quantidade de amostras na prateleira ('.$quantidade_na_prateleira.')!"}');
	}
	editar_prateleira($conn,$prateleira,$matriz,$validade,$capacidade_max,$capacidade_disp_nova);
	die('{"sucesso":1,"msg":"Prateleira editada com sucesso!"}');
}else{
	if ($_SESSION["logado"] == 0){
		die("<html><body><script src='js/sweetalert2.js'></script><script defer>Swal.fire('Por favor, faça login antes de acessar o sistema!').then((result) => {if (result.isConfirmed){window.location.href='/login.php';}})</script></body></html>");
	}
		die('{"sucesso":0,"msg":"Algum erro aconteceu. Por favor, contate o adminstrador do sistema!"}');
}
?>