<?php
include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

if (isset($_POST["lacre"])){
	$lacre = $_POST["lacre"];
}

if (!lacre_existe($conn,$lacre)){
	die('{"sucesso":0,"msg":"Lacre não existe no sistema!"}');
}

if (ja_descartada($conn,$lacre)){
	$prateleira = pega_prateleira($conn,$lacre);
	die('{"sucesso":0,"msg":"'.$lacre.' pertencia a prateleira '.$prateleira.' e já foi descartada!"}');
}

$prateleira = pega_prateleira($conn,$lacre);

die('{"sucesso":1,"msg":"'.$lacre.' está na prateleira '.$prateleira.'"}');

?>