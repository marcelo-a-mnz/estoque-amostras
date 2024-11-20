<?php

$username = "root";
$password = "vera123";
$database = "teste";
$hostname = "localhost";

// criar banco de dados
// create database teste;

// Criar tabela formulario
// create table formulario(prateleira varchar(2),data_amostragem date,lacre varchar(7),data_pra_descarte date,assinatura_cadastro varchar(30),data_descarte date,assinatura_descarte varchar(30));

// Criar tabela prateleiras
// create table prateleiras(prateleira varchar(2),matriz varchar(30),validade varchar(2),capacidade_max varchar(2), capacidade_disp varchar(2));

// Criar tabela usuarios
//  create table usuarios(privilegio varchar(1),usuario varchar(20), senha varchar(60));

$conn = mysqli_connect($hostname,$username, $password,$database) or die( ' Erro na conexão ' );
?>