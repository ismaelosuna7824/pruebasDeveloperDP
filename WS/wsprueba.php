<?php

$intA=$_GET["intA"];
$intB=$_GET["intB"];
          $client = new SoapClient("http://www.dneonline.com/calculator.asmx?WSDL");
          $params = array('intA' => $intA, 'intB' => $intB );
          $result = $client->Multiply($params);
          print_r($result);
          $xmr=$result->MultiplyResult;
          echo "Resultado: ".$xmr;


