<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

if (isset($_POST["prateleira"])){
	if ($_SESSION["privilegio"] != 1){
		die('{"sucesso":0,"msg":"Você não tem permissão para cadastrar prateleiras. Por favor, solicite para um químico responsável fazer isso."}');
	}
	$prateleira = strtoupper($_POST["prateleira"]);
	$matriz = strtoupper($_POST["matriz"]);
	$validade = $_POST["validade"];
	$capacidade_max = $_POST["capacidade-max"];
	$capacidade_disp = $_POST["capacidade-max"];
	
	if (prateleira_existe($conn,$prateleira)){
		die('{"sucesso":0,"msg":"Prateleira já cadastrada!"}');
	}
	cadastrar_prateleira($conn,$prateleira,$matriz,$validade,$capacidade_max,$capacidade_disp);
	die('{"sucesso":1,"msg":"Prateleira cadastrada com sucesso!"}');
}else{
		die('{"sucesso":0,"msg":"Algum erro aconteceu. Por favor, contate o adminstrador do sistema (Marcelo)!"}');
}

?>