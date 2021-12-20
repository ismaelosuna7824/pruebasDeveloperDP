<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

require_once '../WS/DPWS/SapZmfFunction.php';
    
    $data = json_decode(file_get_contents("php://input"));
    $accion = "mostrar";
    $res = array("error"=>false);
    if(isset($_GET['accion']))
        $accion=$_GET['accion'];

        switch ($accion) {
        case 'modificar':

            $IDC = $data->idCliente; 
            $RFC = $data->rfc;
            $Nombre = $data->nombre; 
            $ApellidoP = $data->apellidoP;
            $ApellidoM = $data->apellidoM;
            $Calle = $data->calle;
            $NumeroEx = $data->noExt;
            $Distrito = $data->colonia;
            $CP = $data->codigoPostal;
            $Pais = $data->pais;
            $Region = $data->estado;
            $Telefono= $data->telefono;
            $Email = $data->email;
            $EstadoCivil= $data->estadoCivil;
            $Sexo= $data->sexo;
            $Ciudad= $data->ciudad;
            $NUMINT= $data->noInt;
            $FENAC = $data->fechaN;


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

            $SapZbapisd26Modifclient="SapZbapisd26Modifclient";
            $decoded=$SapZbapisd26Modifclient($AKONT,$Sexo,$ANTLF,$BZIRK,$EstadoCivil,$Email,$Pais,$IDC,$KTGRD,$KZAZU,$Nombre,$ApellidoP,$ApellidoM,$NumeroEx,$NUMINT,$RFC,$LPRIO,$Telefono,$TIPO_CLIENTE,$Ciudad,$Distrito,$PRFRE,$CP,$Region,$SPART,$Calle,$VKORG,$VERSG,$VSBED,$VTWEG,$FENAC);
            
            // $nombreCompleto = $Nombre." ".$ApellidoP." ".$ApellidoM;
            
            // $RFC = $data->RFC;
            $res['data'] = $decoded;
            //$res['data'] = $RFC;
        break;
        }

    echo json_encode($res);
    die();
?>