<?php

require '../vendor/autoload.php';

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

//$opcao = "ambas";
if (isset($_POST["opcao"])){
	$opcao = $_POST["opcao"];
	$prateleira = strtoupper($_POST["prateleira"]);
	$data_inicio = $_POST["data-inicio"];
	$data_final = $_POST["data-final"];
	
	if ($opcao == "cadastradas"){
		$query = 'select * from formulario where prateleira="'.$prateleira.'" and data_descarte is NULL and data_amostragem>="'.$data_inicio.'" and data_amostragem<="'.$data_final.'";';
	}
	if ($opcao == "descartadas"){
		$query = 'select * from formulario where prateleira="'.$prateleira.'" and data_descarte is not NULL and data_descarte>="'.$data_inicio.'" and data_descarte<="'.$data_final.'";';
	}
	if ($opcao == "todas"){
		$query = 'select * from formulario where prateleira="'.$prateleira.'" and data_amostragem>="'.$data_inicio.'" and data_amostragem<="'.$data_final.'";';
	}
	gera_formulario($conn,$prateleira,$query,$opcao);
}

?>