<?php
include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

if (isset($_POST["prateleira"])){
	$prateleira = strtoupper($_POST["prateleira"]);
	$lacre = $_POST["lacre"];
	$prateleira_antiga = pega_prateleira($conn,$lacre);
	$data = $_POST["data"];
		
}

if (!prateleira_existe($conn,$prateleira)){
	$res_json = '{"sucesso":0,"msg":"Prateleira não existe!"}';
	die($res_json);
}

if ($prateleira != $prateleira_antiga){
	$capacidade_disp = pega_capacidade_disp($conn,$prateleira);
	if ($capacidade_disp == "0"){
		die('{"sucesso":0,"msg":"Prateleira sem espaço!"}');
	}
}

if (!lacre_existe($conn,$lacre)){
	die('{"sucesso":0,"msg":"Lacre não existe! Por favor, cadastre a amostra antes de editar."}');
}

if (ja_descartada($conn,$lacre)){
	die('{"sucesso":0,"msg":"Não é permitido editar uma amostra já descartada!"}');
}

editar_amostra($conn,$prateleira,$lacre,$data,$verbose=true);

?>
