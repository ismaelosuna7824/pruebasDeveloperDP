<?php
session_start();
include('wsfacturacion.php');
$email = $_POST["email"];
$password = $_POST["password"];
$newpassword = $_POST["newpassword"];
$confpassword = $_POST["newconfirmpass"];

if($newpassword != $confpassword) {
	header('Location: ../../ContraseñaCambiar.php?r=0');	
	die();
}
	$ClienteCambioContraseña = "ClienteCambioContraseña";
	$decode = $ClienteCambioContraseña($email,$password,$newpassword);
	//print_r($decode);
	if ($decode["success"]){
		header('Location: cerrarconexion.php');		  
	}else{
		header('Location: ../../ContraseñaCambiar.php?r=2');	
	}