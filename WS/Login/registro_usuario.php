<?php
session_start();
include('wsfacturacion.php');
$email = $_POST["email"];
$nombre = $_POST["nombre"];
$rfc = $_POST["rfc"];
$password = $_POST["password"];
$confpassword = $_POST["confirmpass"];

if ( empty($password)||
    empty($confpassword)||
    empty($rfc)||
    empty($nombre)||
    empty($email)) {

	header('Location: ../index.php?v=2');
	die();
}

if($password != $confpassword) {
	header('Location: ../../registro.php?r=0');	
	die();
}
	$ClienteRegister = "ClienteRegister";
	$decode = $ClienteRegister($email,$nombre,$rfc,$password);

	if ($decode["success"]) {
		$_SESSION["RFC"]=$rfc;
		$_SESSION["NOMBRE"]=$nombre;
		$_SESSION["EMAIL"]=$email;
		$_SESSION["PASSWORD"]=$password;
		header('Location: ../../cliente_facturas.php');			  
	}else{
		header('Location: ../../registro.php?r=1');	
	}