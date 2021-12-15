<!DOCTYPE html>
<?php // session_start(); ?>
<html lag="es">
	<head>
		<link rel="icon" type="image/x-icon" href="img/favicon.ico" />
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, ,minimum-scale=1.0">
		<title>Grupo DP</title>
		<link rel="icon" type="image/png" href="image/mvoe.png" />
  		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/esfact.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
 		<style type="text/css">
    		.bs-example{
    			margin: 20px;
    		}
		</style>
	</head>
	<body >
		<?php include("menu.php"); ?>
		<div class="container">
			<div class="row">
    			<div class="col-lg-4 col-sm-offset-4 center">
      				<span class="titulo-formulario">INGRESA TUS DATOS</span>
	  				<hr>
    			</div> 
  			</div>
  			<div class="col-sm-4 col-sm-offset-4">
  				<div id="form" class="main-login main-center">
  					<div class="row">
  						<div class="col-lg-12">
  							<form class="input-append" action="./WS/Login/registro_usuario.php" method="POST" enctype="multipart/form-data">  
								<?php
								  error_reporting(0);
								  $id = $_GET['r'];
								  if(isset($id)){
								    if($id==0){
								        echo'
								        <div class="alert alert-danger">
								          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								          Las contraseñas no coinciden.
								        </div>';
								    } elseif($id==1){
								        echo'
								        <div class="alert alert-danger">
								          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								          Este usuario ya ha sido registrado.
								        </div>';
								    }
								    elseif($id==2){
								        echo'
								        <div class="alert alert-danger">
								          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								          Ingrese todos los datos.
								        </div>';
								    }
								  } 
								?>

								<label>
									<strong>
										<h4>
											<b>RFC:</b>
										</h4>
									</strong>
								</label>   
								<input class="form-control" type="text" name="rfc" required>
								<label>
									<strong>
										<h4>
											<b>Nombre:</b>
										</h4>
									</strong>
								</label>
								<input class="form-control" type="text" name="nombre" required>
								<label>
									<strong>
										<h4>
											<b>Correo electrónico:</b>
										</h4>
									</strong>
								</label>   
								<input class="form-control" type="text" name="email" required>
								<label>
									<strong>
										<h4>
											<b>Contraseña:</b>
										</h4>
									</strong>
								</label> 
								<input class="form-control" type="password" name="password" required>
								<br>
								<label>
									<strong>
										<h4>
											<b>Confirmar Contraseña:</b>
										</h4>
									</strong>
								</label> 
								<input class="form-control" type="password" name="confirmpass" required>
								<br>
								<center>
									<button type="submit" class="btn btn-primary entrar" name="guarda">Registrarse <i class="fa fa-arrow-right"></i></button>
					     		</center>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>