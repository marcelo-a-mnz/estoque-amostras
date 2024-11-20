<?php

include("../php/conexao.php");
include("../php/funcoes.php");

session_start();

if (isset($_POST['modo'])){
	if ($_POST["modo"] == "sistema-protegido"){
		$usuario = $_POST["usuario"];
		$senha = $_POST["senha"];
		login($conn,$usuario,$senha);
	}
	if ($_POST["modo"] == "sistema-livre"){
		$usuario = $_POST["usuario"];
		$_SESSION['usuario'] = strtolower($usuario);
		$_SESSION['senha'] = false;
		$_SESSION['logado'] = 1;
		$_SESSION['privilegio'] = 2;
		header("Location: /index.php");
	}
}

?>