<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

if (isset($_POST["prateleira"])){
	$prateleira = strtoupper($_POST["prateleira"]);
	$lacre = $_POST["lacre"];
	$data = $_POST["data"];
		
}

if (!prateleira_existe($conn,$prateleira)){
	$res_json = '{"sucesso":0,"msg":"Prateleira não existe!"}';
	die($res_json);
}

if (ja_descartada($conn,$lacre)){
	die('{"sucesso":0,"msg":"Não é permitido cadastrar uma amostra já descartada!"}');
}

if ( lacre_ja_cadastrado($conn,$lacre)){
	die('{"sucesso":0,"msg":"Amostra já foi cadastrada antes!"}');
}

cadastrar_amostra($conn,$prateleira,$lacre,$data);

//echo date("Y-m-d", strtotime("2024-01-20 +2 month"));

?>