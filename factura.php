<?php 
  session_start(); 
  $f = fopen("logs/logContador.txt","a");
  fputs($f,"FacturacionCliente"."\r\n") or die("no se pudo crear o insertar el fichero");
  fclose($f);
  if (isset($_GET["RFC"])) {
  
    $POSRFC=strtoupper($_GET["RFC"]); 
    if (strlen($POSRFC)==12) 
    {
     
        $_SESSION["empresarfc"]=$POSRFC;
        header('Location: facturaempresa.php');
        die();
    }
    else{
      if ($POSRFC=='' || empty($POSRFC) )
      {
        header('Location: cliente.php');
        die();
      }
    }
    require_once("./WS/DPconsulta.php");
  } 
  else 
  {
    if (isset($_SESSION["RFC"])) 
    {
      $POSRFC=strtoupper($_SESSION["RFC"]);
      if (strlen($POSRFC)==12) 
      {
          $_SESSION["empresarfc"]=$POSRFC;
          header('Location: facturaempresa.php');
          die();
      }
      require_once("./WS/DPconsulta.php");
    }
    else
    {
      if (isset($_POST["RFC"])) 
      {
        $POSRFC=strtoupper($_POST["RFC"]);
        if ($POSRFC==''||empty($POSRFC) )
        {
          header('Location: cliente.php');
          die();
        }
        if (strlen($POSRFC)==12) 
        {
          $_SESSION["empresarfc"]=$POSRFC;
          header('Location: facturaempresa.php');
          die();
        }
        require_once("./WS/DPconsulta.php");
      }
      else
      {
        header('Location: cliente.php');
      }
    }
  }
  require_once("./WS/Login/wsfacturacion.php");
?>

<html>
<head>
  <title>Grupo DP</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

  <link rel="stylesheet" type="text/css" href="css/esfact.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script Language=Javascript SRC="js/factura.js"></script>
  


</head>
<body>
<?php include("menu.php"); ?>

<div class="container">
  <div class="row main">
    <div id="form" class="main-login main-center">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 center">
          <span class="titulo-formulario">INFORMACIÓN CLIENTES</span>
        </div> 
      </div>
      <hr>
      <div class="row rb-20">
        <div class="col-lg-3">
          RFC:
          <input class="form-control" id="RFC" type="text" name="RFC" value="<?php echo $RFC ?>" disabled>
          <input class="form-control" id="IdCliente" type="text" name="idcliente" value="<?php echo $IDC ?>" style="display: none;">
        </div>  
        <div class="col-lg-3">
          Sexo:
          <select class="form-control" id="Sexo" name="Sexo">
            <?php 
              if ($Sexo=="F") {?>                          
                <option value="F" selected>FEMENINO</option>
                <option value="M">MASCULINO</option>
                <?php } 
                else if($Sexo=="M"){ ?>
                  <option value="F">FEMENINO</option>
                  <option value="M" selected>MASCULINO</option>
                <?php }
                else { ?>
                  <option value="F">FEMENINO</option>
                  <option value="M">MASCULINO</option>
                <?php } ?>
          </select>
        </div>
        <div class="col-lg-3">
          Nombre:
          <input class="form-control" id="Nombre" type="text" name="Nombre" maxlength="100" value="<?php echo $Nombre ?>">
        </div>
        <div class="col-lg-3">
          <span id="apep">Apellido Paterno: </span>
          <input class="form-control" id="ApellidoP" type="text" name="ApellidoP" maxlength="60" value="<?php echo $ApellidoP ?>">
        </div>
        <div class="col-lg-3">
          <span id="apem" >Apellido Materno: </span>
          <input class="form-control" id="ApellidoM" type="text" name="ApellidoM" maxlength="60" value="<?php echo $ApellidoM ?>">
        </div>
        
        <div class="col-lg-3">
          Calle:
          <input class="form-control" id="Calle" maxlength="30" type="text" name="Calle" value="<?php echo $Calle ?>">
        </div>
        <div class="col-lg-3">
          No. Exterior:
          <input class="form-control" id="NumeroEx" type="text" name="NumeroEx" maxlength="5" value="<?php echo $NumeroEx ?>">
        </div>
        <div class="col-lg-3">
          No. Interior:
          <input class="form-control" id="NumeroIn" type="text" name="NumeroIn" maxlength="5" value="<?php echo $NumeroIn ?>">
        </div>
        <div class="col-lg-3">
          Distrito/Colonia:
          <input class="form-control" id="Distrito" type="text" name="Distrito" value="<?php echo $Distrito ?>">
        </div>
        <div class="col-lg-3">
          Código Postal:
          <input class="form-control" id="CP" type="text" name="CP" value="<?php echo $CP?>">
        </div> 
        <div class="col-lg-3">
          Pais:
          <input class="form-control" id="Pais" type="text" name="Pais" value="<?php echo $Pais ?>" disabled>            
        </div>
        <div class="col-lg-3">
          Ciudad:
          <input class="form-control" id="Ciudad" type="text" name="Ciudad" value="<?php echo $Ciudad ?>">            
        </div>
        <div class="col-lg-3">
          Estado:
          <select class="form-control" id="Region" name="Region">
            <option value="<?php echo $Region ?>" selected><?php echo $Region ?></option>
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
            <option value="Sin">Sin Localidad</option>
            <option value="Sin">Sinaloa</option>
            <option value="Son">Sonora</option>
            <option value="Tab">Tabasco</option>
            <option value="Tam">Tamaulipas</option>
            <option value="Tla">Tlaxcala</option>
            <option value="Ver">Veracruz</option>
            <option value="Yuc">Yucatán</option>
            <option value="Zac">Zacatecas</option>
          </select>
          <!--   <input class="form-control" id="Region" type="text" name="Region" value="<?php # echo $Region ?>"> -->
        </div>
        <div class="col-lg-3">
          Telefono:
          <input class="form-control" id="Telefono" type="text" name="Telefono" value="<?php echo $Telefono ?>">
        </div>  
        <div class="col-lg-6">
          Email:
          <input class="form-control" id="Email" type="text" name="Email" value="<?php echo $Email ?>">
        </div>
        <div class="col-lg-3">
          Estado Civil:
          <select class="form-control"  id="EstadoCivil" name="EstadoCivil">
            <option value="<?php echo $EstadoCivil ?>" selected><?php echo $EstadoCivil ?></option>
            <option value="SOLTERO(A)">SOLTERO</option>
            <option value="CASADO(A)">CASADO</option>
          </select>
        </div>   
        <div class="col-lg-3">
          Fecha de Nacimiento:
          <input type="date" class="form-control" id="FechaNacimiento" name="FechaNacimiento" value="<?php echo $FENAC ?>">
        </div>
        <div class="col-lg-5">
          </br>
          <input id="btnsubmit" type="image" src="img/editar.png" />
        </div>  
        <div id="Layout" class="SeparaTicket"></div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          Número de Orden  o Ticket:
          <input class="form-control" type="text" id="Ticket" name="Ticket">
        </div>    
        <div class="col-lg-3">
          Forma de Pago:
          <?php
            $MetodosDePago="MetodosDePago";
            $respuesta=$MetodosDePago();
          ?>
          <select class="form-control" id="MetodoPago" name="MetodoPago">
            <option value="01">Efectivo</option>
            <option value="03">Transferencia electrónica de fondos</option>
            <option value="04">Tarjeta de Crédito</option>
            <option value="28">Tarjeta de Débito</option>
            <option value="99">Otros</option>
          </select> 
        </div>
        <div class="col-lg-3">
          Uso CFDI:
          <?php $UsoDeCFDI = "UsoDeCFDI";
            $respuesta = $UsoDeCFDI();
          ?>
          <select class="form-control"  id="UsoDelCFDI" name="UsoDelCFDI">
            <option value="<?php echo "P01" ?>"> <?php echo $respuesta ?></option>
            <option value="G01">Adquisición de mercancías</option>
            <option value="G03">Gastos en general</option>
          </select> 
        </div>
        <div class="col-lg-4">
          </br>
          <a href="#">
            <input type="image" id="BtnSubmitTicket" src="img/buscar.png" />
          </a>
        </div>
      </div>
      <div class="row">
        <div id="MostrarTicket" class="col-lg-12"></div>    
      </div>
        </br>
        <center>
          <p>Revise que sus datos sean correctos. Una vez emitida su factura no se podrán realizar cambios.</p>
        </center>
        </font>
      </div>
    </div>
  </div>
  <button type="button"  style="display:none;" id="modal" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
  <div class="modal fade" id="myModal" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <center>
          <p>
            <img class="image-responsive" src='img/load.gif'>
          </p>
        </center>    
    </div>
    <button id="cerrarmodal" style="display:none;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
<?php include("footer.php"); ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>