<?php session_start(); ?>
<html>
  <head>
    <title>Grupo DP</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="css/esfact.css">
    <script Language=Javascript SRC="js/clientes.js"></script>
  </head>
  <body>
    <script> 
        function pulsar(e) { 
            tecla = (document.all) ? e.keyCode :e.which; 
            return (tecla!=13); 
        } 
        function verificar_campos(e){

        }
    </script> 
    <?php include("menu.php"); ?>
		<div class="container">
		  <div id="form" class="main-login main-center">
		    <div class="row">
		      <div class="col-lg-8 col-lg-offset-2 center">
		        <span class="titulo-formulario">REGISTRO DEL CLIENTE</span>
		      </div> 
		    </div>
		    <hr>
		    <div class="row rb-20">
		      <div class="col-lg-3">
		          RFC:
		          <?php 
		              error_reporting(0);
		              if (isset($_SESSION["RFC"])) { 
		          ?>
		          <input class="form-control" id="ex1" type="text" value="<?php echo $_SESSION["RFC"]; ?>" name="RFC" onkeypress="return pulsar(event)" required>   
		          <?php } else { 
		              $RFT=$_GET["RFC"];
		              if ($RFT != null || $RFT != '') { 
		          ?>
		          <input class="form-control" id="ex1" type="text" value="<?php echo $RFT; ?>" name="RFC" onkeypress="return pulsar(event)" required>            
		          <?php } else { ?>
		              <input class="form-control" id="ex1" type="text" name="RFC" onkeypress="return pulsar(event)" required>   
		          <?php } ?>  
		          <?php } ?>
		      </div>
		      <div class="col-lg-3">
	          Nombre:
	          <input class="form-control" id="Nombre" type="text" name="Nombre" maxlength="100" onkeypress="return pulsar(event)" required>
		      </div>
		      <div class="col-lg-3">
	          <span id="apep"> Apellido Paterno: </span>
	          <input class="form-control" id="ApellidoP" type="text" name="ApellidoP" maxlength="60" onkeypress="return pulsar(event)" required>
		      </div>
		      <div class="col-lg-3">
		        <span id="apem" >  Apellido Materno: </span>
		        <input class="form-control" id="ApellidoM" type="text" name="ApellidoM" maxlength="60" onkeypress="return pulsar(event)" required>
		      </div>  
		    </div>
		    <div class="row rb-20">
		      <div class="col-lg-6">
		        Calle:
		        <input class="form-control" id="Calle" type="text" name="Calle" maxlength="30" onkeypress="return pulsar(event)" required>
		      </div>
		      <div class="col-lg-3">
			      <div style="width: 40%; float: left;">
			        No. Exterior:
			        <input class="form-control" id="NumeroEx" type="text" name="NumeroEx" maxlength="5" onkeypress="return pulsar(event)" required>
			      </div>
			      <div style="width: 40%; float: right;">
				      No. Interior:
							<input class="form-control" id="NumeroIn" type="text" name="NumeroIn" maxlength="5" onkeypress="return pulsar(event)" required>
			      </div>
		      </div>
		      <div class="col-lg-3">
		          Distrito/Colonia:
		          <input class="form-control" id="Distrito" type="text" name="Distrito" onkeypress="return pulsar(event)" required>
		      </div>
		    </div>
		    <div class="row rb-20">
			    <div class="col-lg-3">
						Codigo Postal:
		        <input class="form-control" id="CP" type="text" name="CP" maxlength="5" onkeypress="return pulsar(event)" required>
			    </div>
			    <div class="col-lg-3">
		          Ciudad:
		          <input class="form-control" id="Ciudad" type="text" name="Ciudad" onkeypress="return pulsar(event)" required>            
		      </div>
		      <div class="col-lg-3">
		        Estado:
		        <select class="form-control"  id="Region" name="Region" onkeypress="return pulsar(event)" required>
		          <option value="Agu">Aguascalientes</option>
		          <option value="Baj">Baja California</option>
		          <option value="Baj">Baja California Sur</option>
		          <option value="Cam">Campeche</option>
		          <option value="Chi">Chiapas</option>
		          <option value="Chi">Chihuahua</option>
		          <option value="Ciu">Ciudad de México</option>
		          <option value="Coa">Coahuila</option>
		          <option value="Col">Colima</option>
		          <option value="Dur">Durango</option>
		          <option value="Est">Estado de México</option>
		          <option value="Gua">Guanajuato</option>
		          <option value="Gue">Guerrero</option>
		          <option value="Hid">Hidalgo</option>
		          <option value="Jal">Jalisco</option>
		          <option value="Mic">Michoacán</option>
		          <option value="Mor">Morelos</option>
		          <option value="Nay">Nayarit</option>
		          <option value="Nue">Nuevo León</option>
		          <option value="Oax">Oaxaca</option>
		          <option value="Pue">Puebla</option>
		          <option value="Que">Querétaro</option>
		          <option value="Qui">Quintana Roo</option>
		          <option value="San">San Luis Potosí</option>
		          <option value="Sin">Sinaloa</option>
		          <option value="Sin">Sin Localidad</option>
		          <option value="Son">Sonora</option>
		          <option value="Tab">Tabasco</option>
		          <option value="Tam">Tamaulipas</option>
		          <option value="Tla">Tlaxcala</option>
		          <option value="Ver">Veracruz</option>
		          <option value="Yuc">Yucatán</option>
		          <option value="Zac">Zacatecas</option>
		        </select>
		      </div>
		      
		      <div class="col-lg-3">
		          Pais:
		          <input  class="form-control" type="text" id="Pais" name="Pais" value="MX" readonly onkeypress="return pulsar(event)" required>            
		      </div>
		      
		    </div>
		    <div class="row rb-20">
			    <div class="col-lg-3">
		          Fecha de Nacimiento:
		          <input type="date" id="FechaNacimiento" class="form-control" name="FechaNacimiento" required>
		      </div>
		      <div class="col-lg-3">
			        Sexo:
		          <select class="form-control"  id="Sexo" name="Sexo" onkeypress="return pulsar(event)" required>
		              <option value="F">FEMENINO</option>
		              <option value="M">MASCULINO</option>
		          </select>
		      </div>
		      <div class="col-lg-3">
		        Estado Civil:
		        <select class="form-control" id="EstadoCivil" name="EstadoCivil" onkeypress="return pulsar(event)" required>
		          <option value="SOLTERO(A)">SOLTERO</option>
		          <option value="CASADO(A)">CASADO</option>
		        </select>
		
		      </div>
		      <div class="col-lg-3">
		        Telefono:
		        <input class="form-control" id="Telefono" type="text" name="Telefono" onkeypress="return pulsar(event)" required>
		      </div>  
		    </div>
		    <div class="row rb-20">
		      <div class="col-lg-3">
		        Correo:
		        <?php if (isset($_SESSION["EMAIL"])){ ?>
		        <input class="form-control" id="Email" type="text" name="Email" value="<?php echo $_SESSION["EMAIL"]; ?>" onkeypress="return pulsar(event)" required>
		        <?php } else{ ?>
		        <input class="form-control" id="Email" type="text" name="Email" onkeypress="return pulsar(event)" required>
		        <?php } ?>
		      </div>
		      
		    </div>
		    <br><br>
		    <div class="row">
		        <div class="col-lg-2"></div>
		        <div class="col-lg-5">
		            <input type="image" id="btnsubmit" class="image-responsive" src="img/Agregar-cliente.png" />
		        </div>  
		        <!-- <div class="col-lg-3">
		            <a href="index.php"> <img class="image-responsive" src="imgRecurso/cerrar.png" width="200px" ></a>
		        </div>  -->
		    </div>
		  </div>
	    <br><br>
	    <button type="button"  style="display:none;" id="modal" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
		<?php include("footer.php"); ?>
	    <div class="modal fade" id="myModal" data-keyboard="false" data-backdrop="static" role="dialog">
	        <div class="modal-dialog">
	            <!-- Modal content-->
	            <center><p><img class="image-responsive" src='img/load.gif'></p></center>    
	        </div>
	        <button id="cerrarmodal" style="display:none;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <script type="text/javascript" src="js/jquery.js"></script> 
	        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	    </div>
    </div>
  </body>
</html>