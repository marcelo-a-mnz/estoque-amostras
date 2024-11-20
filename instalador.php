<?php

// SUA CONFIGURAÇÃO
$username = "root";
$password = "root";
$hostname = "localhost";
$novo_db = 'gerenciador_de_amostras';

$conn = mysqli_connect($hostname,$username, $password) or die( ' Erro na conexão. Por favor, certifique que o usuário e a senha do banco de dados estão corretas! ' );

$query_db = 'create database '.$novo_db.';';
$query_formulario = 'create table '.$novo_db.'.formulario(prateleira varchar(2),data_amostragem date,lacre varchar(7),data_pra_descarte date,assinatura_cadastro varchar(30),data_descarte date,assinatura_descarte varchar(30));';
$query_prateleira = 'create table '.$novo_db.'.prateleiras(prateleira varchar(2),matriz varchar(30),validade varchar(2),capacidade_max varchar(2), capacidade_disp varchar(2));';
$query_usuario = 'create table '.$novo_db.'.usuarios(privilegio varchar(1),usuario varchar(20), senha varchar(60));';

$r_db = mysqli_query($conn,$query_db);
$r_formulario = mysqli_query($conn,$query_formulario);
$r_prateleira = mysqli_query($conn,$query_prateleira);
$r_usuario = mysqli_query($conn,$query_usuario);

if ($r_db && $r_formulario && $r_prateleira && $r_usuario){
	die(' Banco de dados e tabelas criados com sucesso!');
}else{
	die(' Erro de query. Não foi possível criar o banco de dados e as tabelas. ');
}



?>