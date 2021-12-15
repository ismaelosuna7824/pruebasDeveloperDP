<?php 
session_start();
#Variables POST
    $IDC=$_POST["IdCliente"];
    $RFC=$_POST["RFC"];
    $Nombre=$_POST["Nombre"];
    $ApellidoP=$_POST["ApellidoP"];
    $ApellidoM=$_POST["ApellidoM"];
    $Calle=$_POST["Calle"];
    $NumeroEx = $_POST["NumeroEx"];
    $Distrito = $_POST["Distrito"];
    $CP= $_POST["CP"];
    $Pais=$_POST["Pais"];   
    $Region=$_POST["Region"]; 
    $Telefono=$_POST["Telefono"];
    $Email=$_POST["Email"];
    $EstadoCivil=$_POST["EstadoCivil"];
    $Sexo=$_POST["Sexo"];
    $Ciudad=$_POST["Ciudad"];
    $NUMINT=$_POST["NumeroIn"];
    $FENAC = $_POST["FechaNacimiento"];

#Variables POST

#Variables Configurables
    $AKONT="121000001";
    $ANTLF="9";
    $BZIRK="";
    $KTOKD="";
    $I_SORTL="CLIENTE DP";
    $KTGRD="01";
    $KZAZU="X";
    $LPRIO="02";
    $TIPO_CLIENTE="C";
    $PRFRE="X";
    $SPART="10";
    $VKORG="1200";
    $VERSG="1";
    $VSBED="01";
    $VTWEG="10";  
#Variables Configurables

require_once 'DPWS/SapZmfFunction.php';
require_once 'Login/wsfacturacion.php';

     $SapZbapisd26Modifclient="SapZbapisd26Modifclient";
     $decoded=$SapZbapisd26Modifclient($AKONT,$Sexo,$ANTLF,$BZIRK,$EstadoCivil,$Email,$Pais,$IDC,$KTGRD,$KZAZU,$Nombre,$ApellidoP,$ApellidoM,$NumeroEx,$NUMINT,$RFC,$LPRIO,$Telefono,$TIPO_CLIENTE,$Ciudad,$Distrito,$PRFRE,$CP,$Region,$SPART,$Calle,$VKORG,$VERSG,$VSBED,$VTWEG,$FENAC);


     $nombreCompleto = $Nombre." ".$ApellidoP." ".$ApellidoM;
     if (isset($_SESSION["RFC"])) {
         $ClienteModificacion = "ClienteModificacion";
         $boleano = $ClienteModificacion($Email,$nombreCompleto,$_SESSION["RFC"],$_SESSION["PASSWORD"]);
         $_SESSION["NOMBRE"] = $nombreCompleto;
         $_SESSION["EMAIL"] = $Email;
     }

            if (empty($decoded)) {
              //print_r($decoded);
              echo '
    <div class="alert alert-danger alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>¡ERROR!</strong> La moodificacion no se realizo correctamente.
    </div>
              ';
            }else{

            //print_r($decoded);
              echo '
    <div class="alert alert-success alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>¡Correcto!</strong> Modificación Exitosa  
    </div>
    ';
            
            }

            ?>




