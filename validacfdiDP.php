<?php
/* @toro 2018 tar.mx -- consultar estado de factura directo al SAT */
//datos de factura RFC emisor, RFC receptor, Total, UUID
$data = file_get_contents("php://input"); 
$obj = json_decode($data);

/*
// set product property values
$xml->produccion = $obj->produccion;
//$xml->xmlb64 = $data->xmlb64;
$xml->uuid = $obj->uuid;
$xml->rfc = $obj->rfcEmisor;
// create the product
*/

$emisor = $obj->rfcEmisor;
//$emisor="CDP9501269M5";
$receptor = $obj->rfcReceptor;
//$receptor="XAXX010101000";
$total = $obj->total;
//$total="3600";
$uuid = $obj->uuid;
//$uuid="71288E82-F9B4-450A-B975-C8884B8457BC";
//
$soap = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/"><soapenv:Header/><soapenv:Body><tem:Consulta><tem:expresionImpresa>?re='.$emisor.'&amp;rr='.$receptor.'&amp;tt='.$total.'&amp;id='.$uuid.'</tem:expresionImpresa></tem:Consulta></soapenv:Body></soapenv:Envelope>';
//encabezados
$headers = [
    'Content-Type: text/xml;charset=utf-8',
    'SOAPAction: http://tempuri.org/IConsultaCFDIService/Consulta',
    'Content-length: '.strlen($soap)
];

$url = 'https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $soap);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$res = curl_exec($ch);
curl_close($ch);
$xml = simplexml_load_string($res);
$data = $xml->children('s', true)->children('', true)->children('', true);
$data = json_encode($data->children('a', true), JSON_UNESCAPED_UNICODE);
print_r(json_decode($data));