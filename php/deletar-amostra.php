<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);

function deletar_amostra($conn,$lacre){
	$query = ' delete from formulario where lacre="'.$lacre.'";';
	$prateleira = pega_prateleira($conn,$lacre);
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao deletar amostra!"}');
	}else{
		alterar_capacidade($conn,$prateleira,"+1");
		die('{"sucesso":1,"msg":"Amostra deletada com sucesso!"}');
	}
}
if (isset($_POST["lacre"])){
	$lacre = $_POST["lacre"];
	deletar_amostra($conn,$lacre);
}

?>