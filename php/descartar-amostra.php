<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

if (isset($_POST["massivo"])){
	$massivo = true;
}
if (isset($_POST["unico"])){
	$massivo = false;
}

if ($massivo){
	$prateleira = strtoupper($_POST["prateleira"]);
	if (prateleira_existe($conn,$prateleira)){
		descarte_massivo($conn,$prateleira);
	}else{
		die('{"sucesso":0,"msg":"Prateleira não existe!"}');
	}
}

if (!$massivo){
	if (isset($_POST["lacre"])){
		$lacre = $_POST["lacre"];
	}
	if (ja_descartada($conn,$lacre)){
		die('{"sucesso":0,"msg":"Amostra já descartada!"}');
	}else{
		$data_pra_descarte = pega_data_pra_descarte($conn,$lacre);
		if (!lacre_existe($conn,$lacre)){
			die('{"sucesso":0,"msg":"Amostra não cadastrada. Por favor, cadastre-a primeiro antes de descartar!"}');
		}
		if (date("Y-m-d") >= $data_pra_descarte){
			descarte_unico($conn,$lacre);
		}else{
			$date = date("d/m/Y",strtotime(str_replace('-','/',$data_pra_descarte)));
			die('{"sucesso":0,"msg":"Amostra só pode ser descartada em '.trim($date).'"}');
		}
	}
}

?>