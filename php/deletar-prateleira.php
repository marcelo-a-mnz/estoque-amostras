<?php
include("../php/conexao.php");
include("../php/funcoes.php");

session_start();
valida_sessao($conn);


if (isset($_POST['prateleira'])){
	if ($_SESSION["privilegio"] != 1){
		die('{"sucesso":0,"msg":"Você não tem permissão para deletar prateleiras. Por favor, solicite para um químico responsável fazer isso."}');
	}
	$prateleira = strtoupper($_POST["prateleira"]);
	$migrar = $_POST['migrar-amostras'] == 'true' ? true:false;

	$qtd = pega_capacidade_max($conn,$prateleira) - pega_capacidade_disp($conn,$prateleira);
	$migracao_msg = $qtd == '0' ? '':'(Por favor, mover manualmente as amostras para outra prateleira!)';
	if ($migrar && $qtd != '0'){
		$resultado = auto_migrar_amostras($conn,$prateleira);
		$migracao_msg = $resultado == false ? $migracao_msg:'(As amostras foram movidas com sucesso para a prateleira '.$resultado.')';
	}

	if (deletar_prateleira($conn,$prateleira)){
		die('{"sucesso":1,"msg":"Prateleira deletada com sucesso! '.$migracao_msg.'"}');
	}

}
?>