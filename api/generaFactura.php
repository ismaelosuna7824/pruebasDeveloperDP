<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    require_once '../WS/DPWS/SapZmfFunction.php';
    //$SapZbapiSelectclientebyrfc="SapZbapiSelectclientebyrfc";
    
    $data = json_decode(file_get_contents("php://input"));
    $accion = "mostrar";
    $res = array("error"=>false);
    if(isset($_GET['accion']))
        $accion=$_GET['accion'];

        switch ($accion) {
        case 'verFactura':
            $SapZmfCommx1030Generaxmlportal = "SapZmfCommx1030Generaxmlportal";
            $decoded = $SapZmfCommx1030Generaxmlportal("1801211201153829", "1");
            $res['data'] = $decoded;
        break;
        }
//
    echo json_encode($res);
    die();
?>