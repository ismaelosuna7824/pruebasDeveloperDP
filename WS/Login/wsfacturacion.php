<?php
//$GLOBALS="https://facturacion.apps.araconsultoria.com.mx/"; //Produccion

	function ClienteRegister($email,$nombre,$rfc,$password){
		$service_url = 'http://factura.arafacturacion.webaccess.mx/api/v1/portal/register';
		//$service_url = 'http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/portal/register';
	            $curl = curl_init($service_url);
	            $curl_post_data = 
				 [
				 	"email" => $email,
				 	"nombre" => $nombre,
				 	"rfc" => $rfc,
				 	"password" => $password
				 ];
	            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($curl, CURLOPT_POST, true);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	            curl_setopt($curl, CURLOPT_TIMEOUT, 1800000000);
	            $curl_response = curl_exec($curl);
	            if ($curl_response === false) {
	                $info = curl_getinfo($curl);
	                curl_close($curl);
	                die('error occured during curl exec. Additioanl info: ' . var_export($info));
	            }
	            
	            curl_close($curl);

	            return json_decode($curl_response,true);
	}

	function ClienteLogin($email,$password){
		$service_url = 'http://factura.arafacturacion.webaccess.mx/api/v1/portal/login';
		//$service_url = 'http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/portal/login';
	            $curl = curl_init($service_url);
	            $curl_post_data = 
				 [
				 	"email" => $email,
				 	"password" => $password
				 ];
	            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($curl, CURLOPT_POST, true);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	            curl_setopt($curl, CURLOPT_TIMEOUT, 1800000000);
	            $curl_response = curl_exec($curl);
	           // print_r($curl_response);
	            //die();
	            if ($curl_response === false) {
	                $info = curl_getinfo($curl);
	                curl_close($curl);
	                die('error occured during curl exec. Additioanl info: ' . var_export($info));
	            }
	            curl_close($curl);

	            return json_decode($curl_response,true);
	}			


	function ClienteModificacion($email,$nombre,$rfc,$password){ 
		//$service_url = 'http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/portal/update';
		
		$service_url = 'http://factura.arafacturacion.webaccess.mx/api/v1/portal/update';

	            $curl = curl_init($service_url);
	            $curl_post_data = 
				 [
				 	"email" => $email,
				 	"nombre" =>$nombre,
				 	"password" => $password,
				 	"rfc" => $rfc
				 ];
	            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($curl, CURLOPT_POST, true);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	            curl_setopt($curl, CURLOPT_TIMEOUT, 1800000000);
	            $curl_response = curl_exec($curl);
	            if ($curl_response === false) {
	                $info = curl_getinfo($curl);
	                curl_close($curl);
	                die('error occured during curl exec. Additioanl info: ' . var_export($info));
	            }
	            curl_close($curl);

	            return json_decode($curl_response,true);
	}		


function MetodosDePago(){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	//CURLOPT_URL => "http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/catalogos/metodos-pago?find=1,3,4,8,10",
	//CURLOPT_URL => "https://facturacion.apps.araconsultoria.com.mx/api/v1/catalogos/metodos-pago?find=1,3,4,8,10",
	CURLOPT_URL => "http://factura.arafacturacion.webaccess.mx/api/v1/catalogos/metodos-pago?find=1,3,4,8,10",
	//CURLOPT_URL => "http://www.facturadp.com/dportenisWeb/api/MetodoPago?id=1,3,4,8,10",
  	CURLOPT_RETURNTRANSFER => true,
  	CURLOPT_ENCODING => "",
  	CURLOPT_MAXREDIRS => 10,
  	CURLOPT_TIMEOUT => 30,
  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  	CURLOPT_CUSTOMREQUEST => "GET",
  	CURLOPT_HTTPHEADER => array(
    	"authorization: Basic am9zZS5uYXJhbmpvQGRwb3J0ZW5pcy5jb20ubXg6ImpeWkFiUFFRN1xuPTZ1Qw==",
    	"cache-control: no-cache",
    	"postman-token: 5a7858eb-f65c-2d0e-0dea-1cd642e16af1"),
	));

	$curl_response = curl_exec($curl);

	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
	  echo "CURL Error #:" . $err;
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	return json_decode($curl_response,true);
}

function UsoDeCFDI(){
	return "Por definir";
}
	function ClienteConsultarFacturas($fecha,$fechaF,$rfc,$page){
			$curl = curl_init();
			curl_setopt_array($curl, array(
			 //CURLOPT_URL => "http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/bills?company_id=*&start_date=".$fecha."&end_date=".$fechaF."&q=".$rfc."&page=".$page,
			 CURLOPT_URL => "http://factura.arafacturacion.webaccess.mx/api/v1/bills?company_id=*&start_date=".$fecha."&end_date=".$fechaF."&q=".$rfc."&page=".$page,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 1800000000,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "authorization: Basic am9zZS5uYXJhbmpvQGRwb3J0ZW5pcy5jb20ubXg6ImpeWkFiUFFRN1xuPTZ1Qw==",
			    "cache-control: no-cache",
			    "postman-token: 5a7858eb-f65c-2d0e-0dea-1cd642e16af1"
			  ),
			));

			$curl_response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  echo "CURL Error #:" . $err;
	          die('error occured during curl exec. Additioanl info: ' . var_export($info));
			}

	        return json_decode($curl_response,true);
	}	

	function TicketFacturado($Ticket){
			$curl = curl_init();
			curl_setopt_array($curl, array(
			 //CURLOPT_URL => "http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/bills/count?q=".$Ticket,
			 //CURLOPT_URL => "https://facturacion.apps.araconsultoria.com.mx/api/v1/bills/count?q=".$Ticket,
			  CURLOPT_URL => "http://www.facturadp.com/dportenisWeb/api/Ticket?ticket=".$Ticket,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 1800000000,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			));

			$curl_response = curl_exec($curl);
			//print_r($curl_response);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  echo "CURL Error #:" . $err;
	          die('error occured during curl exec. Additioanl info: ' . var_export($info));
			}
	        return json_decode($curl_response);
	}	

	function ClienteCambioContraseña($email,$password,$newpassword){
		$service_url = 'http://factura.arafacturacion.webaccess.mx/api/v1/portal/change-password';
		//$service_url = 'http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/portal/change-password';
	            $curl = curl_init($service_url);
	            $curl_post_data = 
				 [
				 	"email" => $email,
				 	"password"=>$password,
				 	"new_password"=>$newpassword
				 ];
	            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($curl, CURLOPT_POST, true);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	            curl_setopt($curl, CURLOPT_TIMEOUT, 1800000000);
	            $curl_response = curl_exec($curl);
	            if ($curl_response === false) {
	                $info = curl_getinfo($curl);
	                curl_close($curl);
	                die('error occured during curl exec. Additioanl info: ' . var_export($info));
	            }
	            curl_close($curl);

	            return json_decode($curl_response,true);
	}	

	function ClienteCorreo($email,$uuid){
			$curl = curl_init();

			curl_setopt_array($curl, array(
			 // CURLOPT_URL => "http://dev.facturacion.apps.araconsultoria.com.mx/api/v1/bills/send",
			  CURLOPT_URL => "http://factura.arafacturacion.webaccess.mx/api/v1/bills/send",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 1800000000,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\n".$email."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"uuid\"\r\n\r\n".$uuid."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			  CURLOPT_HTTPHEADER => array(
			    "authorization: Basic am9zZS5uYXJhbmpvQGRwb3J0ZW5pcy5jb20ubXg6ImpeWkFiUFFRN1xuPTZ1Qw==",
			    "cache-control: no-cache",
			    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			    "postman-token: 0d183e1e-6c78-46be-b65f-5ebccec13c5a"
			  ),
			));

			$curl_response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  //echo $curl_response;
			}

	            return json_decode($curl_response,true);
	}