<?php
session_start();
include('wsfacturacion.php');

$email = $_POST["email"];
$password = $_POST["password"];

	$ClienteLogin = "ClienteLogin";
	$decode = $ClienteLogin($email,$password);

	if ($decode["success"]) {
		$_SESSION["RFC"]=$decode["user"]["rfc"];
		$_SESSION["NOMBRE"]=$decode["user"]["nombre"];
		$_SESSION["EMAIL"]=$decode["user"]["email"];
		$_SESSION["PASSWORD"]=$password;
		header('Location: ../../cliente_facturas.php');			  	
	}else{
		header('Location: ../../registro.php');
	}