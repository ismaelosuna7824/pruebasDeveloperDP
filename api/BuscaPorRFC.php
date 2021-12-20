<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    require_once '../WS/DPWS/SapZmfFunction.php';
    $SapZbapiSelectclientebyrfc="SapZbapiSelectclientebyrfc";
    
    $data = json_decode(file_get_contents("php://input"));
    $accion = "mostrar";
    $res = array("error"=>false);
    if(isset($_GET['accion']))
        $accion=$_GET['accion'];

        switch ($accion) {
        case 'mostrarCliente':
            $RFC = $data->RFC;
            $res['data'] = $SapZbapiSelectclientebyrfc($RFC);
            //$res['data'] = $RFC;
        break;
        }

    echo json_encode($res);
    die();
?>