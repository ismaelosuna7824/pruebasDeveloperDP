<?php 

#Variables POST
    $RFC=$_POST["RFC"];
    $Nombre=$_POST["Nombre"];
    $ApellidoP=$_POST["ApellidoP"];
    $Calle=$_POST["Calle"];
    $NumeroEx = $_POST["NumeroEx"];
    $Distrito = $_POST["Distrito"];
    $CP= $_POST["CP"];
    $Pais=$_POST["Pais"];   
    $Region=$_POST["Region"]; 
    $Telefono=$_POST["Telefono"];
    $Email=$_POST["Email"];
    $EstadoCivil=$_POST["EstadoCivil"];
    $Sexo="E";
    $Ciudad=$_POST["Ciudad"];
    $NUMINT=$_POST["NumeroIn"];
    $FENAC = $_POST["FechaNacimiento"];
#Variables POST

#Variables Configuracion
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
#Variables Configuracion   
require_once 'DPWS/SapZmfFunction.php';

    $SapZbapiSelectclientebyrfc="SapZbapiSelectclientebyrfc";
    $decoded = $SapZbapiSelectclientebyrfc($RFC);

if (!empty($decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"])) {
  
              echo '
    <div class="alert alert-danger alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>RFC Existente!</strong> Este RFC ya ha sido registrado.
    </div>
              ';


}else{
    $SapZbapisd26AltaEmpresa="SapZbapisd26AltaEmpresa";
    $EstadoCivil=" ";
    $decoded = $SapZbapisd26AltaEmpresa($AKONT,$Sexo,$ANTLF,$BZIRK,$KTOKD,$EstadoCivil,$Email,$Pais,$I_SORTL,$KTGRD,$KZAZU,$Nombre,$ApellidoP,$NumeroEx,$NUMINT,$RFC,$LPRIO,$Telefono,$TIPO_CLIENTE,$Ciudad,$Distrito,$PRFRE,$CP,$Region,$SPART,$Calle,$VKORG,$VERSG,$VSBED,$VTWEG,$FENAC);

            if (empty($decoded)) {
                //print_r("Respuesta: ".$decoded);
              echo '
    <div class="alert alert-danger alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>ERROR!</strong> Faltan datos por agregar.
    </div>
              ';
            }else{
                //print_r("Respuesta: ".$decoded);
              echo "1";
            }

}
