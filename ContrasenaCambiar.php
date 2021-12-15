<!DOCTYPE html>
<?php  session_start(); 
if (!isset($_SESSION["RFC"])) {
    header('Location: index.php');
    die();
}
?>
<html lag="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, ,minimum-scale=1.0">
<title>Grupo DP</title>
<link rel="icon" type="image/png" href="image/mvoe.png" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/esfact.css">

<style type="text/css">
    .bs-example{
    	margin: 20px;
    }
</style>


</head>
<body >
<header>
</header>
<?php include("menu.php"); ?>
<section class="jumbotron login">
<div class="container">

<form class="input-append" action="./WS/Login/cambiar_password_usuario.php" method="POST" enctype="multipart/form-data">  
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
          Ocurrio un problema intentelo mas tarde.
        </div>';
    }
  } 
?>  

       <input class="form-control" type="text" name="email" value="<?php echo $_SESSION["EMAIL"];?>" style="display: none;">
       <label><strong><h4><b>Contraseña Anterior:</b></h4></strong></label>   
       <input class="form-control" type="password" placeholder="************" name="password">
       <label> <strong><h4><b>Contraseña Nueva:</b></h4></strong></label> 
       <input class="form-control" type="password" placeholder="************" name="newpassword"><br>
       <label> <strong><h4><b>Confirmar Contraseña Nueva:</b></h4></strong></label> 
       <input class="form-control" type="password" placeholder="************" name="newconfirmpass" ><br>
     <center><input type="submit" class="btn btn-success" name="guarda" value="Cambiar"> </center>
</form>
</div>
</section>

<?php include("footer.php"); ?>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/bootstrap.js"></script> 
</body>
</html>