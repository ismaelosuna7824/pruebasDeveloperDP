<?php
session_start();
include('wsfacturacion.php');
$uuid = $_POST["uuid"];
$email = $_POST["email"];

	$ClienteCorreo = "ClienteCorreo";
	$decode = $ClienteCorreo($email,$uuid);
		if ($decode["success"]){

			echo '
	    <div class="alert alert-success alert-dismissable fade in">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    <strong>Corro enviado!</strong>  El correo '.$email.' ha recibido el pdf y xml  
	    </div>
			';	  
		}else{

					echo '
			    <div class="alert alert-danger alert-dismissable fade in">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    <strong>ERROR!</strong> Al enviar el correo intente mas tarde.
	    </div>
			';
			

		}