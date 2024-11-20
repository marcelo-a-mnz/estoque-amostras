<?php

include("conexao.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

error_reporting(0);

function prateleira_existe($conn,$prateleira){
	$query = 'select * from prateleiras where prateleira="'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao checar se prateleira existe!"}');
	}
	if (mysqli_num_rows($result_query)==0) { 
		return false;
	}
	else{
		return true;
	}
}

function pega_username(){
	return $_SESSION["usuario"];
}

function pega_data_pra_descarte($conn,$lacre){
	$query = 'select data_pra_descarte from formulario where lacre="'.$lacre.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao pegar data pra  descarte!"}');
	}
	while ($row = mysqli_fetch_array($result_query)){
		return $row['data_pra_descarte'];
	}
}

function lacre_existe($conn,$lacre){
	$query = 'select * from formulario where lacre="'.$lacre.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao checar se lacre existe!"}');
	}
	if (mysqli_num_rows($result_query)==0) { 
		return false;
	}
	else{
		return true;
	}
}

function descarte_massivo($conn,$prateleira){
	$query = 'select lacre from formulario where prateleira="'.$prateleira.'" and data_pra_descarte <= now() and data_descarte is NULL;';
	$usuario = pega_username();
	$resultado = mysqli_query($conn,$query);
	if (!$resultado){
		die('{"sucesso":0,"msg":"Erro ao realizar o descarte massivo de amostras!"}');
	}
	$cont = 0;
	if (!mysqli_num_rows($resultado)==0){
		$json_txt = '{"sucesso": 1,"msg":"","lacres":[]}';
	
	}else{
		die('{"sucesso": 0,"msg":"Não há amostras na prateleira para serem descartadas. Caso haja, por favor, cadastre-a(s) primeiro!"}');
	}
	$json_obj = json_decode($json_txt);
	while ($row = mysqli_fetch_array($resultado)){
		$lacre = $row['lacre'];
		$query2 = 'update formulario set data_descarte=now(),assinatura_descarte="'.$usuario.'" where lacre="'.$lacre.'";';
		$resultado2 = mysqli_query($conn,$query2);
		alterar_capacidade($conn,$prateleira,"+1");
		$cont += 1;
		$json_obj->msg = 'Amostras descartadas com sucesso! Lacres abaixo: ';
		$json_obj->lacres[] = $lacre;
	}
	die(json_encode($json_obj));
}

function descarte_unico($conn,$lacre){
	$usuario = pega_username();
	$query = 'update formulario set data_descarte=now(),assinatura_descarte="'.$usuario.'" where lacre="'.$lacre.'";';
	$json_txt = '{"sucesso": 1,"msg":"Amostra descartada com sucesso! Lacres baixo: ","lacres":[]}';
	$json_obj = json_decode($json_txt);
	$resultado = mysqli_query($conn,$query);
	if (!$resultado){
		die('{"sucesso":0,"msg":"Erro ao realizar o descarte unico de amostras!"}');
	}
	$json_obj->lacres[] = $lacre;
	$prateleira = pega_prateleira($conn,$lacre);
	alterar_capacidade($conn,$prateleira,"+1");
	die(json_encode($json_obj));
}

function lacre_ja_cadastrado($conn,$lacre){
	$query = 'select * from formulario where lacre="'.$lacre.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao checar se o lacre já foi cadastrado!"}');
	}
	if (mysqli_num_rows($result_query)==0) { 
		return false;
	}
	else{
		return true;
	}
}

function pega_validade($conn,$prateleira){
	$query = 'select validade from prateleiras where prateleira="'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao pegar validade!"}');
	}
	while ($row = mysqli_fetch_array($result_query)) { 
      return $row['validade'];
	}
}

function pega_prateleira($conn,$lacre){
	$query = 'select prateleira from formulario where lacre="'.$lacre.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao pegar prateleira!"}');
	}
	while ($row = mysqli_fetch_array($result_query)){
		return $row['prateleira'];
	}
}

function pega_matriz($conn,$prateleira){
	$query = 'select matriz from prateleiras where prateleira="'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao pegar matriz!"}');
	}
	while ($row = mysqli_fetch_array($result_query)){
		return $row['matriz'];
	}
}

//echo intval("10")-intval("3");
//die();

function pega_prateleiras($conn){
	$query = 'select * from prateleiras;';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao pegar prateleiras!"}');
	}
	return $result_query;
}

function pega_capacidade_disp($conn,$prateleira){
	$query = 'select capacidade_disp from prateleiras where prateleira="'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao pegar capacidade disponivel!"}');
	}
	while ($row = mysqli_fetch_array($result_query)){
		return $row['capacidade_disp'];
	}
}

function pega_capacidade_max($conn,$prateleira){
	$query = 'select capacidade_max from prateleiras where prateleira="'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao pegar capacidade maxima!"}');
	}
	while ($row = mysqli_fetch_array($result_query)){
		return $row['capacidade_max'];
	}
}

function alterar_capacidade($conn,$prateleira,$x){
	$query = 'update prateleiras set capacidade_disp=cast(capacidade_disp as unsigned)'.$x.' where prateleira="'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao alterar capacidade!"}');
	}
}

function ja_descartada($conn,$lacre){
	$query = 'select lacre from formulario where data_descarte is not NULL and lacre="'.$lacre.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		die('{"sucesso":0,"msg":"Erro ao checar se amostra já foi descartada!"}');
	}
	if (mysqli_num_rows($result_query)==0) { 
		return false;
	}
	else{
		return true;
	}
}

function cadastrar_amostra($conn,$prateleira,$lacre,$data){
	$capacidade_disp = pega_capacidade_disp($conn,$prateleira);
	if ($capacidade_disp == "0"){
		die('{"sucesso":0,"msg":"Prateleira sem espaço!"}');
	}
	$validade = pega_validade($conn,$prateleira);
	$data_pra_descarte = date("Y-m-d", strtotime($data." +".$validade." month"));
	$usuario = pega_username();
	if (!lacre_ja_cadastrado($conn,$lacre)){
		$query1 = 'insert into formulario(lacre) values("'.trim($lacre).'")';
		$resultado1 = mysqli_query($conn,$query1);
		$res_json = '{"sucesso":1,"msg":"Amostra cadastrada com sucesso!"}';
		alterar_capacidade($conn,$prateleira,"-1");
		
	}else{
		
		$res_json = '{"sucesso":1,"msg":"Dados da amostram atualizados com sucesso!"}';
	}
	$prateleira_antiga = pega_prateleira($conn,$lacre);

	if ($prateleira_antiga){
		if ($prateleira_antiga != $prateleira){
			alterar_capacidade($conn,$prateleira_antiga,"+1");
			alterar_capacidade($conn,$prateleira,"-1");
		}
	}

	$query2 = 'update formulario set prateleira="'.trim($prateleira).'",data_amostragem=str_to_date("'.trim($data).'","%Y-%m-%d"),data_pra_descarte=str_to_date("'.$data_pra_descarte.'","%Y-%m-%d"),assinatura_cadastro="'.trim($usuario).'" where lacre="'.trim($lacre).'";';
	$resultado = mysqli_query($conn,$query2);
	if (!$resultado){
		die('{"sucesso":0,"msg":"Ocorreu algum erro ao cadastrar amostra!"}');
	}
	die($res_json);
}

function editar_amostra($conn,$prateleira,$lacre,$data,$verbose){
	$capacidade_disp = pega_capacidade_disp($conn,$prateleira);
	$validade = pega_validade($conn,$prateleira);
	$data_pra_descarte = date("Y-m-d", strtotime($data." +".$validade." month"));
	$usuario = pega_username();
	$prateleira_antiga = pega_prateleira($conn,$lacre);

	if ($prateleira_antiga != $prateleira){
			alterar_capacidade($conn,$prateleira_antiga,"+1");
			alterar_capacidade($conn,$prateleira,"-1");
	}

	$query2 = 'update formulario set prateleira="'.trim($prateleira).'",data_amostragem=str_to_date("'.trim($data).'","%Y-%m-%d"),data_pra_descarte=str_to_date("'.$data_pra_descarte.'","%Y-%m-%d"),assinatura_cadastro="'.trim($usuario).'" where lacre="'.trim($lacre).'";';
	$resultado = mysqli_query($conn,$query2);
	if (!$resultado && $verbose){
		die('{"sucesso":0,"msg":"Ocorreu algum erro ao editar amostra!"}');
	}
	if ($verbose){
		die('{"sucesso":1,"msg":"Dados da amostra atualizados com sucesso!"}');
	}
}

function cadastrar_prateleira($conn,$prateleira,$matriz,$validade,$capacidade_max,$capacidade_disp){
	$query1 = 'insert into prateleiras(prateleira) values("'.trim($prateleira).'")';
	$resultado1 = mysqli_query($conn,$query1);
	if (!$resultado1){
		die('{"sucesso":0,"msg":"Ocorreu algum erro ao cadastrar prateleira (1)!"}');
	}
	$query2 = 'update prateleiras set matriz="'.$matriz.'",validade="'.$validade.'",capacidade_max="'.$capacidade_max.'",capacidade_disp="'.$capacidade_disp.'" where prateleira="'.$prateleira.'";';
	//die($query2);
	$resultado2 = mysqli_query($conn,$query2);
	if (!$resultado2){
		die('{"sucesso":0,"msg":"Ocorreu algum erro ao cadastrar prateleira (2)!"}');
	}
}

function editar_prateleira($conn,$prateleira,$matriz,$validade,$capacidade_max,$capacidade_disp){
	$query2 = 'update prateleiras set matriz="'.$matriz.'",validade="'.$validade.'",capacidade_max="'.$capacidade_max.'",capacidade_disp="'.$capacidade_disp.'" where prateleira="'.$prateleira.'";';
	$resultado2 = mysqli_query($conn,$query2);
	if (!$resultado2){
		die('{"sucesso":0,"msg":"Ocorreu algum erro ao editar prateleira!"}');
	}
}

function pega_quant_na_prateleira($conn,$prateleira){
	$query = 'select lacre from formulario where data_descarte is NULL and prateleira="'.$prateleira.'";';
	$resultado1 = mysqli_query($conn,$query);
	return mysqli_num_rows($resultado1);
}

function gera_xlsx2($matriz,$prateleira){
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../php/formulario.xlsx");
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->getCell("C3")->setValue($matriz);
	$sheet->getCell("F3")->setValue($prateleira);
	$sheet->getStyle("F3")->getFont()->getColor()->setRGB("FF0000");
	return $spreadsheet;
}

function write_in_xlsx2($spreadsheet,$celula,$valor){
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->getCell($celula)->setValue($valor);
	$sheet->getStyle($celula)->getAlignment()->setHorizontal("center");
	return $spreadsheet;
}

function save_in_xlsx2($spreadsheet,$nome_arquivo){
	$writer = new Xlsx($spreadsheet);
	$writer->save($nome_arquivo);
}

function random($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
 
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
 
    return $randomString;
}

function gera_formulario($conn,$prateleira,$query,$opcao){
	$matriz = pega_matriz($conn,$prateleira);
	$resultado1 = mysqli_query($conn,$query);
	if (mysqli_num_rows($resultado1)==0){
		die('{"sucesso":0,"msg":"Não foi encontrada nenhuma amostra baseada nas opções que você escolheu!"}');
	}
	
	$cont_linhas = 0;
	$cont_celula = 8;
	$limite_linhas = 58;
	$spreadsheet = gera_xlsx2($matriz,$prateleira);
	$temp_file = "1111".random(10).".xlsx";
	$tmpfiles = array();
	$tmpfiles[] = $temp_file;
	while ($row = mysqli_fetch_array($resultado1)){
		if ($cont_linhas == $limite_linhas){
			$spreadsheet = gera_xlsx2($matriz,$prateleira);
			$temp_file = "1111".random(10).".xlsx";
			$tmpfiles[] = $temp_file;
			$cont_linhas = 0;
			$cont_celula = 8;
		}
		$data_amostragem = $row['data_amostragem'];
		$data_amostragem_br = implode("/",array_reverse(explode("-",$data_amostragem)));
		$lacre = $row['lacre'];
		$data_pra_descarte = $row['data_pra_descarte'];
		$data_pra_descarte_br = implode('/', array_reverse(explode('-', $data_pra_descarte)));
		$assinatura_cadastro = $row['assinatura_cadastro'];
		$data_descarte = $row['data_descarte'];
		$data_descarte_br = implode('/', array_reverse(explode('-', $data_descarte)));
		$assinatura_descarte = $row['assinatura_descarte'];
		
		write_in_xlsx2($spreadsheet,"A".$cont_celula,$data_amostragem_br);
		write_in_xlsx2($spreadsheet,"B".$cont_celula,$lacre);
		write_in_xlsx2($spreadsheet,"C".$cont_celula,$assinatura_cadastro);
		write_in_xlsx2($spreadsheet,"D".$cont_celula,$data_pra_descarte_br);
		write_in_xlsx2($spreadsheet,"E".$cont_celula,$data_descarte_br);
		write_in_xlsx2($spreadsheet,"F".$cont_celula,$assinatura_descarte);
		save_in_xlsx2($spreadsheet,$temp_file);
		
		$cont_celula += 1;
		$cont_linhas += 1;
	}
	$json_txt = '{"sucesso": 1,"msg":"Arquivos gerados com sucesso!","arquivos64":[],"opcao":""}';
	$json_obj = json_decode($json_txt);
	$json_obj ->opcao = $opcao;
	foreach ($tmpfiles as $fl){
		$json_obj->arquivos64[] = base64_encode(file_get_contents($fl)); 
		unlink($fl);
	}
	die(json_encode($json_obj));
		
}

function pega_privilegio($conn,$usuario){
	$query = 'select privilegio from usuarios where usuario="'.$usuario.'";';
	$result_query = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_array($result_query)){
		return $row['privilegio'];
	}
}

function usuario_existe($conn,$usuario){
	$query = 'select usuario from usuarios where usuario="'.$usuario.'";';
	$result_query = mysqli_query($conn,$query);
	if (mysqli_num_rows($result_query)==0) { 
		return false;
	}
	else{
		return true;
	}
}

function tem_amostra_pra_descarte($conn,$prateleira){
	$data_hoje = date("Y-m-d");
	$query = 'select lacre from formulario where prateleira="'.$prateleira.'" and data_pra_descarte <= "'.$data_hoje.'" and assinatura_descarte is NULL;';
	$result_query = mysqli_query($conn,$query);
	if (mysqli_num_rows($result_query)>0) {
		return true;
	
	}else{
		return false;
	}
}

function login($conn,$usuario,$senha){
	if (!usuario_existe($conn,$usuario)){
		die('{"sucesso":0,"msg":"Usuário não está cadastrado!"}');
	}
	
	$query = 'select usuario from usuarios where usuario="'.$usuario.'" and senha="'.$senha.'"';
	$result_query = mysqli_query($conn,$query);
	if (mysqli_num_rows($result_query)==0) { 
	$_SESSION["logado"] = 0;
		die('{"sucesso":0,"msg":"Usuário ou senha incorretos!"}');
	}
	else{
		$privilegio = pega_privilegio($conn,$usuario);
		$_SESSION['usuario'] = $usuario;
		$_SESSION['senha'] = $senha;
		$_SESSION['logado'] = 1;
		$_SESSION['privilegio'] = $privilegio;
		die('{"sucesso":1,"msg":"Logado com sucesso!","location":"/index.php"}');
	}
}

function valida_sessao($conn){
	if ($_SESSION["logado"] == 0){
		die("<html><body><script src='js/sweetalert2.js'></script><script defer>Swal.fire('Por favor, faça login antes de acessar o sistema!').then((result) => { if (result.isConfirmed) { window.location.href = '/logout.php'; } })</script></body></html>");
	}
	if (!usuario_existe($conn,$_SESSION["usuario"])){
		die("<html><body><script src='js/sweetalert2.js'></script><script defer>Swal.fire('Seu usuário não está mais cadastrado no sistema. Por favor, faça login com outro usuário!').then((result) => { if (result.isConfirmed) { window.location.href = '/logout.php'; } })</script></body></html>");
	}
}

function params_js(){
	$arg_list = func_get_args();
	$params_js_out = "";
    foreach($arg_list as $arg){
    	$params_js_out .= "'".$arg."',";
    }
    return $params_js_out;
}

function pega_amostras_presentes($conn,$prateleira){
	$query = 'select * from formulario where prateleira="'.$prateleira.'" and data_descarte is NULL;';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		return false;
	}else{
		return $result_query;
	}
}

function pega_prateleira_com_espaco($conn,$prateleira,$matriz,$qtd){
	$query = 'select * from prateleiras where matriz="'.$matriz.'"';
	$query .= ' and capacidade_disp > '.$qtd.'';
	$query .= ' and prateleira != "'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	if (!$result_query){
		return false;
	}else{
		foreach($result_query as $row){
			return $row['prateleira'];
		}
		
	}
}

function auto_migrar_amostras($conn,$prateleira){
	$matriz = pega_matriz($conn,$prateleira);
	$qtd = pega_capacidade_max($conn,$prateleira) - pega_capacidade_disp($conn,$prateleira);
	$prateleira_com_espaco = pega_prateleira_com_espaco($conn,$prateleira,$matriz,$qtd);
	if ($qtd == '0' || $prateleira_com_espaco == false){
		return false; // Não é possível migrar amostras
	}
	$prateleira_dados = pega_amostras_presentes($conn,$prateleira);
	foreach($prateleira_dados as $amostra){
		$lacre = $amostra['lacre'];
		$data_amostragem = $amostra['data_amostragem'];
		$data_pra_descarte = pega_data_pra_descarte($conn,$lacre);
		editar_amostra($conn,$prateleira_com_espaco,$lacre,$data_amostragem,$verbose=false);
	}
	return $prateleira_com_espaco; // Amostras migradas com sucesso
}

function deletar_prateleira($conn,$prateleira){
	$query = 'delete from prateleiras where prateleira="'.$prateleira.'";';
	$query2 = 'update formulario set prateleira = NULL where prateleira="'.$prateleira.'";';
	$result_query = mysqli_query($conn,$query);
	$result_query2 = mysqli_query($conn,$query2);
	if ($result_query && $result_query2){
		return true;
	}else{
		return false;
	}
}

?>