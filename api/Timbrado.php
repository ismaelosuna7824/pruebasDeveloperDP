<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

require_once '../dompdf/autoload.inc.php';
require_once '../QR/qrlib.php';
require_once 'WS/DPWS/SapZmfFunction.php';
require_once 'Login/wsfacturacion.php';
use Dompdf\Dompdf;


// $ApellidoM = "";
// $TelefonoViejo = "01 800 0028 774";

// if (isset($_POST["ApellidoM"])) {
//     $ApellidoM = $_POST["ApellidoM"];
// }

//$Calle = $_POST["Calle"];
//$NumeroEx = $_POST["NumeroEx"];
//$NumeroInt = $_POST["NumeroInt"];
//$Distrito = $_POST["Distrito"];
//$CP = $_POST["CP"];
//$Pais = $_POST["Pais"];
//$Region = $_POST["Region"];
//$Telefono = $_POST["Telefono"];
//$Email = $_POST["Email"];
//$EstadoCivil = $_POST["EstadoCivil"];
//$Sexo = $_POST["Sexo"];
//$Ciudad = $_POST["Ciudad"];
//$Ticket = $_POST["Ticket"];
//$FormaDePago = $_POST["MetodoPago"];




//$zip = $_POST['zip'];
//$namezip=$_POST['namezip'];





    //$SapZbapiSelectclientebyrfc="SapZbapiSelectclientebyrfc";
    
    $data = json_decode(file_get_contents("php://input"));
    $accion = "mostrar";
    $res = array("error"=>false);
    if(isset($_GET['accion']))
        $accion=$_GET['accion'];
        
        
        switch ($accion) {
        case 'timbradoF':
            $NumeroInt = $data->NumeroInt;
            $Ticket = $data->Ticket;
            $FormaDePago = $data->MetodoPago; 
            $FormaPagoEgreso = "";
            $MetodoPagoEgreso = "";
            $UsoCFDI = $data->UsoDelCFDI;
            $MetodoDePago = "PUE"; //$MetodoDePago." ".$MetodoPagoTexto;
            $Ingreso = "";
            $documento = "";
            $nUsoCFDI = 0;
            $dir = "";

            $RFC = $data->RFC;
            $Nombre = $data->Nombre;
            $ApellidoP = $data->ApellidoP;

try //inicia Facturacion Dp
{
    $T_RETORNO = 1;
    $Lista2 = "";
    $NombreAd = "";
    $paso = 0;
    //Consulta ticket en SAP
    $SapZmfCommx1030Generaxmlportal = "SapZmfCommx1030Generaxmlportal";
    $decoded = $SapZmfCommx1030Generaxmlportal($Ticket, $T_RETORNO);
    $contador = count($decoded, COUNT_RECURSIVE);
    if ($contador < 4) {
        if ($i == 1) {
            
                    $res['data'] = [false, "Folio del ticket incorrecto.Ingrese un folio valido."];
            die();
        }
    } 
    else {
        #Lleno los campos del Receptor
        $string = base64_decode($decoded["SapZmfCommx1030Generaxmlportal"]["E_XML"]);
        if (! array_key_exists('E_MENSAJE', $decoded["SapZmfCommx1030Generaxmlportal"])) 
        {
            $stringCopia = $string;
            $findme = "</cfdi:Comprobante>";

            $pieces = explode($findme, $stringCopia);

            $nRegistros = count($pieces);
            $numXml = 0;
            $nContadorEntregas = 0;
            $ListaAdjuntos = [];
            $NombreAdjuntos = [];
            $nListadoAdjuntos = 0;
            $zip = new ZipArchive();
            $nSegundos = 0;
            try {
                foreach ($pieces as $element) {
                    $stringXML = (string) $pieces[$numXml].'</cfdi:Comprobante>';

                    if (strcasecmp($stringXML, '</cfdi:Comprobante>') == 0) {
                    } else { //aocegueda 2018/06/18
                        $string = $stringXML;
                        //echo '<pre>', htmlentities($string), '</pre>';
                        for ($i = 1; $i <= 2; $i++) //Ciclo para generar factura de ingreso y egreso
                        {
                            if ($NumeroInt != "" || ! empty($NumeroInt)) {
                                $string = str_replace('" codigoPostal', '" noInterior="" codigoPostal', $string);
                            }
                            $xml = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
                            $articulos = "";
                            $CadenaOriginal = "";
                            //foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor')as $Receptor)
                            libxml_use_internal_errors(true);
                            $sxe = simplexml_load_string($xml);
                            if ($sxe === false) {
                                foreach (libxml_get_errors() as $error) {
                                    $res['data'] = [false, $error];
                                    //echo "\t", $error->message;
                                }
                            }
                            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados//cfdi:CfdiRelacionado') as $CFDIRelacionado) {
                                $relacionado = $CFDIRelacionado['UUID'];
                                if (strlen($relacionado) > 1) {
                                    #Ingresar datos del Receptor
                                    if ($i == 1) {

                                        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                            $Receptor["Rfc"] = $RFC;
                                            $Receptor["Nombre"] = $Nombre." ".$ApellidoP." ".$ApellidoM;
                                        }
                                    }
                                    if ($i == 2) {
                                        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                            $Receptor["Rfc"] = "XAXX010101000";
                                            $Receptor["Nombre"] = "PUBLICO EN GENERAL";
                                        }
                                    }
                                    #Lleno los campos del Receptor

                                    foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
                                        $fechaTicket = $cfdiComprobante['Fecha'];
                                        $nSegundos = $nSegundos++;
                                        $nuevafecha = date('Y-m-d\TH:i:s', time());
                                        if ($i == 1) {
                                            $cfdiComprobante['MetodoPago'] = $MetodoDePago;
                                            $FormaPagoEgreso = $cfdiComprobante['FormaPago'];
                                            $cfdiComprobante['FormaPago'] = $FormaDePago;
                                        }
                                        if ($i == 2) {
                                            $cfdiComprobante['MetodoPago'] = "PUE"; //$metodoDePago;
                                        }
                                    }// Fin foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
                                    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                        if ($i == 2) {
                                            $Receptor['UsoCFDI'] = "P01";
                                        } else {
                                            if ($nUsoCFDI == 0) {
                                                $UsoCFDITemp = $UsoCFDI;
                                                $Receptor['UsoCFDI'] = $UsoCFDITemp;
                                                $nUsoCFDI++;
                                            } else {
                                                $Receptor['UsoCFDI'] = $UsoCFDITemp;
                                            }
                                        }
                                    } // FIN foreach ($xml ->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor)
                                    #lleno los campos de metodo de pago
                                    $documento = '';
                                    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Entregas//cfdi:Entrega') as $Entregas) {
                                        $documento = $Entregas['documento'];
                                    }

                                    //Pido el numero de Entrega del Documento
                                    $xmlstring = base64_encode($xml->asXml());
                                    //die();
                                    #Timbrar XML
                                    if ($i == 1) //Factura Ingreso
                                    {
                                        try {
                                            ini_set('max_execution_time', 300);
                                            //$client = new SoapClient("https://arafacturacion.com/Dportenis33/Service.asmx?WSDL");
                                            //$client = new SoapClient("108.174.197.60/Dportenis33/Service.asmx?WSDL");
                                            $client = new SoapClient("https://www.facturadp.com/Dportenis33/Service.asmx?WSDL");
                                            $params = ['xml' => $xmlstring, 'produccion' => "NO", 'ticket' => $Ticket];
                                            $result = $client->FacturacionCliente($params);
                                            //print_r($result);
                                            $xmr = $result->FacturacionClienteResult;
                                        } catch (Exception $e) {
                                            error_log($e, 3, 'error_dp.log');
                                            //echo $e;
                                            // echo '
                                            //     <div class="alert alert-danger alert-dismissable fade in">
                                            //         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            //         <strong>ERROR!</strong> Error en el XML Favor de Revisar.
                                            //     </div>';
                                                $res['data'] = [false, "Error en el XML Favor de Revisar."];
                                            //die();
                                        }
                                    }
                                    if ($i == 2) // Factura Egreso
                                    {
                                        try //Consume Servicio de Facturacion
                                        {
                                            //$client = new SoapClient("https://arafacturacion.com/Dportenis33/Service.asmx?WSDL");
                                            ini_set('max_execution_time', 300);
                                            $client = new SoapClient("https://facturadp.com/Dportenis33/Service.asmx?WSDL");
                                            $params = ['xml' => $xmlstring, 'produccion' => "NO", "ticket" => $Ticket];
                                            //echo 'Xml Error <pre>', htmlentities($xmlstring), '</pre>';
                                            $result = $client->FacturacionClienteEgreso($params);
                                            $xmr = $result->FacturacionClienteEgresoResult;
                                        } catch (Exception $e) {
                                            // echo "Error: ".$e;
                                            // error_log($e, 3, 'error_dp.log');
                                            // echo "Error al consultar".$e;

                                            $res['data'] = [false, $e];
                                        }
                                    }
                                    $findme = '<error>';
                                    $pos = strpos($xmr, $findme);
                                    //echo '<pre>', htmlentities($xmr), '</pre>';
                                    if ($pos <= 0) // Busca si hubo error en la respuesta del servicio
                                    {
                                        $quitar = [
                                            '<?xml version="1.0" encoding="UTF-8"?>',
                                            "<xmlBase64>",
                                            "</xmlBase64>",
                                            "</xml>",
                                        ];
                                        $onlyconsonants = str_replace($quitar, "", $xmr);
                                        //if ($i == 1) 
                                        {
                                            if (count($ListaAdjuntos) > 0) {
                                                foreach ($ListaAdjuntos as $value) {
                                                    $Lista2 .= $value."|";
                                                }
                                                foreach ($NombreAdjuntos as $value1) {
                                                    $NombreAd .= $value1."|";
                                                }// </table> Revisar aocegueda
                                            }
                                        }
                                    } else {
                                        $quitar = [
                                            '<?xml version="1.0" encoding="UTF-8"?>',
                                            "<xmlBase64>",
                                            "</xmlBase64>",
                                            "</xml>",
                                        ];
                                        $onlyconsonants = str_replace($quitar, "", $xmr);

                                        if ($i == 1) {
                                            // echo '
                                            // <div class="alert alert-danger alert-dismissable fade in">
                                            //     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            //     <strong></strong>'.$onlyconsonants.' ERROR .
                                            // </div>';
                                            $res['data'] = [false, $onlyconsonants ];
                                            if (count($ListaAdjuntos) > 0) {
                                                foreach ($ListaAdjuntos as $value) {
                                                    $Lista2 .= $value."|";
                                                }
                                                foreach ($NombreAdjuntos as $value1) {
                                                    $NombreAd .= $value1."|";
                                                }// </table> Revisar aocegueda
                                                echo '
                                                <tr>
                                                  <td><p></p></td>
                                                  <td><p></p></td>
                                                  <td><img id="email"  class="image-responsive" src="img/email.png"></td>
                                                </tr>
                                                <input class="form-control" id="zip" type="submit"  style="display: none;" name="action" value="'.$Lista2.'">
                                                <input class="form-control" id="namezip" type="submit" style="display: none;"  name="action" value="'.$NombreAd.'" >              
                                                <div id="respuesta"></div>';
                                            }
                                        }
                                    }

                                    $vowels = ["<?xml version='1.0'?>", "<xmlBase64>", "</xmlBase64>", "</xml>"];
                                    $onlyconsonants = str_replace($vowels, "", $xmr);
                                    $xmd = base64_decode($onlyconsonants);
                                    #Timbrar XML
                                    if ($i == 1) // Genera factura ingreso
                                    {
                                        $previous = libxml_use_internal_errors(true);
                                        $xmlTimbrado = simplexml_load_string($xmd, 'SimpleXMLElement', LIBXML_NOCDATA);
                                        if (! $xmlTimbrado) {
                                            libxml_use_internal_errors($previous);
                                            die();
                                        }
                                        $ns = $xmlTimbrado->getNamespaces(true);
                                        $xmlTimbrado->registerXPathNamespace('t', $ns['tfd']);
                                    }
                                    if ($i == 2)  // Genera factura egreso
                                    {
                                        if (empty($xmd) || $xmd == '') {
                                            // echo '
                                            //     <div class="alert alert-danger alert-dismissable fade in">
                                            //         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            //         <strong>ERROR!</strong> Folio del ticket incorrecto. <b>Ingrese</b> un folio valido.
                                            //     </div>';
                                                $res['data'] = [false, "Folio del ticket incorrecto. Ingrese un folio valido."];
                                            die();
                                        }

                                        $xmlTimbrado = simplexml_load_string($xmd, 'SimpleXMLElement', LIBXML_NOCDATA);
                                        $ns = $xmlTimbrado->getNamespaces(true);
                                        $xmlTimbrado->registerXPathNamespace('t', $ns['tfd']);
                                    }

                                    $folio = "";
                                    $certificado = "";
                                    $noCertificado = "";
                                    $version = "";
                                    $fecha = "";
                                    $tipoDeComprobante = "";
                                    $descuento = "";
                                    $total = "";
                                    $formaDePago = "";
                                    $condicionesDePago = "";
                                    $metodoDePago = "";
                                    $LugarExpedicion = "";
                                    $NumCtaPago = "";

                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
                                        $certificado = $cfdiComprobante['Certificado'];
                                        $noCertificado = $cfdiComprobante['NoCertificado'];
                                        $version = $cfdiComprobante['Version'];
                                        $folio = $cfdiComprobante['Folio'];
                                        $fecha = $cfdiComprobante['Fecha'];
                                        $tipoDeComprobante = $cfdiComprobante['TipoDeComprobante'];
                                        $descuento = $cfdiComprobante['Descuento'];
                                        $total = $cfdiComprobante['Total'];
                                        $formaDePago = $cfdiComprobante['FormaPago'];
                                        $condicionesDePago = $cfdiComprobante['condicionesDePago'];
                                        $metodoDePago = $cfdiComprobante['MetodoPago'];
                                        $LugarExpedicion = $cfdiComprobante['LugarExpedicion'];
                                        $Moneda = $cfdiComprobante['Moneda'];
                                        $SubTotal = $cfdiComprobante['SubTotal'];
                                    }

                                    $nombre = "";
                                    $Emisor = "";

                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor) {
                                        $nombre = $Emisor['Nombre'];
                                        $RfcEmisor = $Emisor['Rfc'];
                                        $Regimen = $Emisor['RegimenFiscal'];
                                    }

                                    #Variables Receptor
                                    $recNombre = "";
                                    $recRfc = "";

                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                        $recRfc = $Receptor['Rfc'];
                                        $recNombre = $Receptor['Nombre'];
                                        $UsoCFDI = $Receptor['UsoCFDI'];
                                    }

                                    #Variables Traslado
                                    $base = "";
                                    $impuesto = "";
                                    $ImporteImpuesto = "";
                                    $tipoFactor = "";
                                    $tasaOCuota = "";
                                    $base1[] = "";
                                    $impuesto1[] = "";
                                    $ImporteImpuesto1[] = "";
                                    $tipoFactor1[] = "";
                                    $tasaOCuota1[] = "";
                                    #Variables Traslado
                                    $detallesPDF = '';
                                    $a = 0;

                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado) {
                                        $base = $Traslado['Base'];
                                        $impuesto = $Traslado['Impuesto'];
                                        $tipoFactor = $Traslado['TipoFactor'];
                                        $tasaOCuota = $Traslado['TasaOCuota'];
                                        $ImporteImpuesto = $Traslado['Importe'];
                                        $base1[$a] = $base;
                                        $impuesto1[$a] = $impuesto;
                                        $tipoFactor1[$a] = $tipoFactor;
                                        $tasaOCuota1[$a] = $tasaOCuota;
                                        $ImporteImpuesto1[$a] = $ImporteImpuesto;
                                        ++$a;
                                    }

                                    $z = 0;
                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto) {
                                        $Valorunitario = $Concepto["ValorUnitario"];
                                        $Importe = $Concepto["Importe"];
                                        $Descuento = $Concepto["Descuento"];
                                        $articulos .= '
                                            <tr> 
                                                <td>'.$Concepto["ClaveProdServ"].'</td> 
                                                <td class="left">'.$Concepto["Descripcion"].'</td>
                                                <td>'.$Concepto["Cantidad"].'</td> 
                                                <td>'.$Concepto["ClaveUnidad"].'</td>
                                                <td>'.number_format((float) $Valorunitario, 2).'</td>
                                                <td>'.number_format((float) $Importe, 2).'</td> 
                                                <td>'.number_format((float) $Descuento, 2).'</td> 
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Base:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$base1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Impuesto:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$impuesto1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Tipo Factor:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$tipoFactor1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Tasa o Cuota:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$tasaOCuota1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Importe Impuesto:</span>
                                                            </td>
                                                            <td>      
                                                                <span style="font-size:9px;">'.$ImporteImpuesto1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>';
                                        ++$z;
                                    }

                                    $numeroSerSAT = "";
                                    $FechaTimbrado = "";
                                    $selloCFD = "";
                                    $UUID = "";

                                    foreach ($xmlTimbrado->xpath('//t:TimbreFiscalDigital') as $Concepto) {
                                        $UUID = $Concepto["UUID"];
                                        $numeroSerSAT = $Concepto["NoCertificadoSAT"];
                                        $FechaTimbrado = $Concepto["FechaTimbrado"];
                                        $selloCFD = $Concepto["SelloCFD"];
                                    }

                                    $xdoc = new DomDocument();
                                    $xdoc->loadXML($xmd);
                                    $XSL = new DOMDocument();
                                    $XSL->load('cadenaoriginal_3_3.xslt');
                                    $proc = new XSLTProcessor;
                                    $proc->registerPHPFunctions();
                                    $proc->importStyleSheet($XSL);
                                    $CadenaOriginal = $proc->transformToXML($xdoc);
                                    $QR = "?re=".$Emisor."&rr=".$recRfc."&tt=".$UUID;
                                    #Datos para el PDF
                                    $matrixPointSize = 4;
                                    $TimbradoFecha = explode("T", $FechaTimbrado);
                                    if ($i == 1) //Inserta la factura Timbrada en SAP Dportenis Ingreso
                                    {
                                        /* Descomentar es solo para prueba */
                                        $SapZmfCommx1033FactPortal = "SapZmfCommx1033FactPortal";
                                        // $SapZmfCommx1033FactPortal($Ticket, $documento, $UUID, $tipoDeComprobante, $TimbradoFecha);
                                    }
                                    if ($i == 2) //Inserta la factura Timbrada en SAP Dportenis Egreso
                                    {
                                        /* Descomentar es solo para prueba */
                                        $SapZmfCommx1033FactPortal = "SapZmfCommx1033FactPortal";
                                        $tipoDeComprobante = "E";
                                       // $SapZmfCommx1033FactPortal($Ticket, $documento, $UUID, $tipoDeComprobante, $TimbradoFecha);
                                    }

                                    #Convierto PDF, XML y QR
                                    if ($i == 1) {
                                        # code...
                                        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../QR/temp'.DIRECTORY_SEPARATOR;
                                        $PNG_WEB_DIR = '../QR/temp/';
                                        $filename = $PNG_TEMP_DIR.'tes'.$RFC.'.png';
                                        $errorCorrectionLevel = 'L';
                                        $filename = $PNG_TEMP_DIR.'test'.md5($QR.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                                        QRcode::png($QR, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                                        $imagen = base64_encode($PNG_WEB_DIR.basename($filename));
                                        $SubTotal = number_format((float) $SubTotal, 2);
                                        $Importe = number_format((float) $Importe, 2);
                                        $total = number_format((float) $total, 2);

                                        if (! isset($pdf)) {
                                            require("DpStringPdf33.php");
                                        }

                                        $Dompdf = new Dompdf();
                                        $Dompdf->load_html($pdf);
                                        $Dompdf->set_paper('A4', 'portrait');
                                        $Dompdf->render();
                                        $pdfs = $Dompdf->output();

                                        file_put_contents("../Facturas/".$folio."_".$nContadorEntregas.".pdf", $pdfs);
                                        file_put_contents("../Facturas/".$folio."_".$nContadorEntregas.".xml", $xmd);
                                        #Convierto PDF, XML y QR
                                        // Creamos un instancia de la clase ZipArchive
                                        $zip = new ZipArchive();
                                        // Creamos y abrimos un archivo zip temporal
                                        $zip->open("../Facturas/".$folio.".zip", ZipArchive::CREATE);
                                        // Añadimos un directorio
                                        $dir = "../Facturas/".$folio.".zip";
                                        // Añadimos un archivo en la raid del zip.
                                        $zip->addFile("../Facturas/".$folio."_".$nContadorEntregas.".pdf", "".$folio."_".$nContadorEntregas.".pdf");
                                        $Nombres = "".$folio."_".$nContadorEntregas.".pdf";
                                        $NombreAdjuntos[$nListadoAdjuntos] = $Nombres;
                                        $listadoNombre = "../Facturas/".$folio."_".$nContadorEntregas.".pdf";
                                        $ListaAdjuntos[$nListadoAdjuntos] = $listadoNombre;
                                        $nListadoAdjuntos++;
                                        $zip->addFile("../Facturas/".$folio."_".$nContadorEntregas.".xml", "".$folio."_".$nContadorEntregas.".xml");
                                        $Nombres = "".$folio."_".$nContadorEntregas.".xml";
                                        $NombreAdjuntos[$nListadoAdjuntos] = $Nombres;
                                        $listadoNombre = "../Facturas/".$folio."_".$nContadorEntregas.".xml";
                                        $ListaAdjuntos[$nListadoAdjuntos] = $listadoNombre;
                                        $nListadoAdjuntos++;
                                        // Una vez añadido los archivos deseados cerramos el zip.
                                        $zip->close();

                                        if ($nContadorEntregas == 0) {
                                            // echo "
                                            //         <table style='width:100%'>
                                            //             <thead>
                                            //                 <tr>
                                            //                     <th>PDF</th>
                                            //                     <th>XML</th>
                                            //                     <th>E-Mail</th>
                                            //                 </tr>
                                            //             </thead>";
                                            $res['data'] = [false, "Sin Facturas"];
                                        }

                                        // echo '
                                        //     <tr>
                                        //         <td>
                                        //             <a  href="Facturas/'.$folio."_".$nContadorEntregas.'.pdf" download="Facturas/'.$folio."_".$nContadorEntregas.'.pdf">
                                        //                 <img class="image-responsive" src="img/PDF.png"></a>
                                        //         </td>
                                        //         <td>
                                        //             <a id="descargarXml" download href="Facturas/'.$folio."_".$nContadorEntregas.'.xml" download="Facturas/'.$folio."_".$nContadorEntregas.'.xml">
                                        //                 <img  class="image-responsive" src="img/XML.png"></a>
                                        //         </td>
                                        //         <td>
                                        //             <p></p>
                                        //         </td>
                                        //     </tr>';

                                            $res['data'] = [true, '"Facturas/'.$folio."_".$nContadorEntregas.'.pdf"', '"Facturas/'.$folio."_".$nContadorEntregas.'.xml"'];
                                        unset($GLOBALS['pdf']);
                                    } //Ingreso
                                } //Relacionado
                                else {
                                    if ($paso == 0) {
                                        // echo '
                                        //     <div class="alert alert-danger alert-dismissable fade in">
                                        //         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        //         <strong>ERROR!</strong> Error al generar los archivos de Factura,
                                        //          Cualquier duda o aclaración favor de comunicarse al 
                                        //         66 99 15 53 00.</div>';
                                                $res['data'] = [false, "Error al generar los archivos de Factura,
                                                Cualquier duda o aclaración favor de comunicarse al 
                                               66 99 15 53 00."];
                                        $paso++;
                                    }
                                    break;

                                    return;
                                }
                            }
                        }//Fin for Ciclo genera factura Ingreso Egreso

                    }

                    $numXml++;
                    $nContadorEntregas++;
                } // Fin foreach($pieces as $element)

                foreach ($ListaAdjuntos as $value) {
                    $Lista2 .= $value."|";
                }

                foreach ($NombreAdjuntos as $value1) {
                    $NombreAd .= $value1."|";
                }

                if (count($ListaAdjuntos) > 0) {
                    foreach ($ListaAdjuntos as $value) {
                        $Lista2 .= $value."|";
                    }

                    //print_r($Lista2);

                    foreach ($NombreAdjuntos as $value1) {
                        $NombreAd .= $value1."|";
                    }

                    //print_r($NombreAd);
                    // echo '
                    //     <tr>
                    //         <td></td>
                    //         <td></td>
                    //         <td><img id="email"  class="image-responsive" src="img/email.png"></td>
                    //      </tr>
                    //      <input class="form-control" id="zipx" type="submit"  style="display: none;" name="action" value="'.$Lista2.'">
                    //      <input class="form-control" id="namezip" type="submit" style="display: none;"  name="action" value="'.$NombreAd.'" >              
                    //     <div id="respuesta"></div>';
                    $res['data'] = [false, "lista que no se de que es"];
                }
            } catch (Exception $e) {
                $res['data'] = [false, $e];
            }
        } else {
            $stringMensaje = $decoded["SapZmfCommx1030Generaxmlportal"]["E_MENSAJE"];
            if (strpos($stringMensaje, 'devolucion de todos los artículos') || strpos($stringMensaje, 'Ticket sin artículos pendientes')) {
                $stringMensaje = str_replace("01 800 0028 774", "66 99 15 53 00", $stringMensaje); 
                // echo '
                //         <div class="alert alert-danger alert-dismissable fade in">
                //             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$stringMensaje.'            
                //         </div>';
                        $res['data'] = [false, $stringMensaje];
            } else {
                if (strpos($stringMensaje, 'folio de ticket contiene devoluciones')) {
                    $stringMensaje = str_replace("01 800 0028 774", "66 99 15 53 00", $stringMensaje);
                    // echo '
                    //         <div class="alert alert-danger alert-dismissable fade in">
                    //             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$stringMensaje.'            
                    //         </div>';
                    $res['data'] = [false, $stringMensaje];
                }

                $stringCopia = $string;
                $findme = "</cfdi:Comprobante>";
                $pieces = explode($findme, $stringCopia);
                $nRegistros = count($pieces);
                $numXml = 0;
                $nContadorEntregas = 0;
                $ListaAdjuntos = [];
                $NombreAdjuntos = [];
                $nListadoAdjuntos = 0;
                $zip = new ZipArchive();
                $nSegundos = 0;

                foreach ($pieces as $element) {
                    $stringXML = (string) $pieces[$numXml].'</cfdi:Comprobante>';
                    if (strcasecmp($stringXML, '</cfdi:Comprobante>') == 0) {
                    } else {   //aocegueda 2018/06/18
                        $string = $stringXML;
                        //echo '<pre>', htmlentities($string), '</pre>';
                        for ($i = 1; $i <= 2; $i++) //Ciclo para generar factura de ingreso y egreso
                        {
                            if ($NumeroInt != "" || ! empty($NumeroInt)) {
                                $string = str_replace('" codigoPostal', '" noInterior="" codigoPostal', $string);
                            }

                            $xml = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
                            $articulos = "";
                            $CadenaOriginal = "";

                            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados//cfdi:CfdiRelacionado') as $CFDIRelacionado) {
                                $relacionado = $CFDIRelacionado['UUID'];
                                if (strlen($relacionado) > 1) {
                                    //aocegueda
                                    #Ingresar datos del Receptor
                                    if ($i == 1) //ingreso
                                    {
                                        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                            $Receptor["Rfc"] = $RFC;
                                            $Receptor["Nombre"] = $Nombre." ".$ApellidoP." ".$ApellidoM;
                                        }
                                    }

                                    if ($i == 2) //egreso
                                    {
                                        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                            $Receptor["Rfc"] = "XAXX010101000";
                                            $Receptor["Nombre"] = "PUBLICO EN GENERAL";
                                        }
                                    }

                                    foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
                                        $fechaTicket = $cfdiComprobante['Fecha'];
                                        $nSegundos = $nSegundos++;
                                        $nuevafecha = date('Y-m-d\TH:i:s', time() + $nSegundos);
                                        $cfdiComprobante['Fecha'] = $nuevafecha;

                                        if ($i == 1) //Ingreso
                                        {
                                            $cfdiComprobante['MetodoPago'] = $MetodoDePago;
                                            $FormaPagoEgreso = $cfdiComprobante['FormaPago'];
                                            $cfdiComprobante['FormaPago'] = $FormaDePago;
                                        }
                                        if ($i == 2) //Egreso
                                        {
                                            $cfdiComprobante['MetodoPago'] = "PUE"; //$metodoDePago;
                                        }
                                    }
                                    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                        if ($i == 2) //Egreso
                                        {
                                            $Receptor['UsoCFDI'] = "P01";
                                        } else {
                                            if ($nUsoCFDI == 0) {
                                                $UsoCFDITemp = $UsoCFDI;
                                                $Receptor['UsoCFDI'] = $UsoCFDITemp;
                                                $nUsoCFDI++;
                                            } else {
                                                $Receptor['UsoCFDI'] = $UsoCFDITemp;
                                            }
                                        }
                                    }
                                    #lleno los campos de metodo de pago
                                    $documento = '';
                                    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Entregas//cfdi:Entrega') as $Entregas) {
                                        $documento = $Entregas['documento'];
                                    }
                                    //Pido el numero de Entrega del Documento
                                    $xmlstring = base64_encode($xml->asXml());
                                    //echo '<pre>', htmlentities($xmlstring), '</pre>';
                                    //die();
                                    #Timbrar XML
                                    if ($i == 1) // Ingreso
                                    {
                                        try {
                                            ini_set('max_execution_time', 300);
                                            //$client = new SoapClient("https://arafacturacion.com/Dportenis33/Service.asmx?WSDL");
                                            $client = new SoapClient("https://www.facturadp.com/Dportenis33/Service.asmx?WSDL");
                                            //$params = array('xml' => $xmlstring, 'produccion' => "1" ,"ticket" => $Ticket  );
                                            $params = ['xml' => $xmlstring, 'produccion' => "NO", 'ticket' => $Ticket];
                                            //echo '<pre>', htmlentities($xmlstring), '</pre>';
                                            $result = $client->FacturacionCliente($params);
                                            $xmr = $result->FacturacionClienteResult;
                                        } catch (Exception $e) {
                                            error_log($e, 3, 'error_dp.log');
                                            echo "Error al consultar".$e;
                                        }
                                    }
                                    if ($i == 2) {
                                        try //Consume Servicio de Facturacion
                                        {
                                            ini_set('max_execution_time', 300);
                                            //$client = new SoapClient("https://arafacturacion.com/Dportenis33/Service.asmx?WSDL");
                                            $client = new SoapClient("https://facturadp.com/Dportenis33/Service.asmx?WSDL");
                                            $params = ['xml' => $xmlstring, 'produccion' => "NO", "ticket" => $Ticket];
                                            $result = $client->FacturacionClienteEgreso($params);
                                            $xmr = $result->FacturacionClienteEgresoResult;
                                        } catch (Exception $e) {
                                            // error_log($e, 3, 'error_dp.log');
                                            // echo "Error al consultar".$e;
                                            $res['data'] = [false, $e];
                                        }
                                    }
                                    $findme = '<error>';
                                    $pos = strpos($xmr, $findme);
                                    if ($pos !== false) // Busca si hubo error en la respuesta del servicio
                                    {
                                        $quitar = [
                                            '<?xml version="1.0" encoding="UTF-8"?>',
                                            "<xmlBase64>",
                                            "</xmlBase64>",
                                            "</xml>",
                                        ];
                                        $onlyconsonants = str_replace($quitar, "", $xmr);
                                        if ($i == 1) {
                                            echo '
                                                    <div class="alert alert-danger alert-dismissable fade in">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        <strong></strong>'.$onlyconsonants.' ERROR .
                                                    </div>';
                                            if (count($ListaAdjuntos) > 0) {
                                                foreach ($ListaAdjuntos as $value) {
                                                    $Lista2 .= $value."|";
                                                }
                                                foreach ($NombreAdjuntos as $value1) {
                                                    $NombreAd .= $value1."|";
                                                } //</table> Revisar aocegueda
                                                echo '
                                                        <tr>
                                                            <td><p></p></td>
                                                            <td><p></p></td>
                                                            <td><img id="email"  class="image-responsive" src="img/email.png"></td>
                                                        </tr>
                                                        <input class="form-control" id="zip" type="submit"  style="display: none;" name="action" value="'.$Lista2.'">
                                                        <input class="form-control" id="namezip" type="submit" style="display: none;"  name="action" value="'.$NombreAd.'" >              
                                                        <div id="respuesta"></div>';
                                            }
                                        }
                                    } // Fin Error
                                    $vowels = ["<?xml version='1.0'?>", "<xmlBase64>", "</xmlBase64>", "</xml>"];
                                    $onlyconsonants = str_replace($vowels, "", $xmr);
                                    $xmd = base64_decode($onlyconsonants);
                                    #Timbrar XML
                                    if ($i == 1) // Genera factura ingreso
                                    {
                                        if (empty($xmd) || $xmd == '') {
                                            // echo '
                                            //         <div class="alert alert-danger alert-dismissable fade in">
                                            //             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            //             <strong>ERROR!</strong> Folio del ticket incorrecto. <b>Ingresé</b> un folio válido.
                                            //         </div>';

                                                    $res['data'] = [false, "Folio del ticket incorrecto. Ingresé un folio válido."];
                                            die();
                                        }
                                        #Datos para el PDF
                                        $xmlTimbrado = simplexml_load_string($xmd, 'SimpleXMLElement', LIBXML_NOCDATA);
                                        $ns = $xmlTimbrado->getNamespaces(true);
                                        $xmlTimbrado->registerXPathNamespace('t', $ns['tfd']);
                                    }
                                    if ($i == 2)  // Genera factura egreso
                                    {
                                        if (empty($xmd) || $xmd == '') {
                                            // echo '
                                            //         <div class="alert alert-danger alert-dismissable fade in">
                                            //             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            //             <strong>ERROR!</strong> Folio del ticket incorrecto. <b>Ingrese</b> un folio valido.
                                            //         </div>';
                                                    $res['data'] = [false, "Folio del ticket incorrecto. <b>Ingrese</b> un folio valido."];
                                            die();
                                        }
                                        $xmlTimbrado = simplexml_load_string($xmd, 'SimpleXMLElement', LIBXML_NOCDATA);
                                        $ns = $xmlTimbrado->getNamespaces(true);
                                        $xmlTimbrado->registerXPathNamespace('t', $ns['tfd']);
                                    }
                                    $folio = "";
                                    $certificado = "";
                                    $noCertificado = "";
                                    $version = "";
                                    $fecha = "";
                                    $tipoDeComprobante = "";
                                    $descuento = "";
                                    $total = "";
                                    $formaDePago = "";
                                    $condicionesDePago = "";
                                    $metodoDePago = "";
                                    $LugarExpedicion = "";
                                    $NumCtaPago = "";
                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
                                        $certificado = $cfdiComprobante['Certificado'];
                                        $noCertificado = $cfdiComprobante['NoCertificado'];
                                        $version = $cfdiComprobante['Version'];
                                        $folio = $cfdiComprobante['Folio'];
                                        $fecha = $cfdiComprobante['Fecha'];
                                        $tipoDeComprobante = $cfdiComprobante['TipoDeComprobante'];
                                        $descuento = $cfdiComprobante['Descuento'];
                                        $total = $cfdiComprobante['Total'];
                                        $formaDePago = $cfdiComprobante['FormaPago'];
                                        $condicionesDePago = $cfdiComprobante['condicionesDePago'];
                                        $metodoDePago = $cfdiComprobante['MetodoPago'];
                                        $LugarExpedicion = $cfdiComprobante['LugarExpedicion'];
                                        $Moneda = $cfdiComprobante['Moneda'];
                                        $SubTotal = $cfdiComprobante['SubTotal'];
                                    }
                                    $nombre = "";
                                    $Emisor = "";
                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor) {
                                        $nombre = $Emisor['Nombre'];
                                        $RfcEmisor = $Emisor['Rfc'];
                                        $Regimen = $Emisor['RegimenFiscal'];
                                    }
                                    #Variables Receptor
                                    $recNombre = "";
                                    $recRfc = "";
                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                                        $recRfc = $Receptor['Rfc'];
                                        $recNombre = $Receptor['Nombre'];
                                        $UsoCFDI = $Receptor['UsoCFDI'];
                                    }
                                    #Variables Traslado
                                    $base = "";
                                    $impuesto = "";
                                    $ImporteImpuesto = "";
                                    $tipoFactor = "";
                                    $tasaOCuota = "";
                                    $base1[] = "";
                                    $impuesto1[] = "";
                                    $ImporteImpuesto1[] = "";
                                    $tipoFactor1[] = "";
                                    $tasaOCuota1[] = "";
                                    #Variables Traslado
                                    $detallesPDF = '';
                                    $a = 0;
                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado) {
                                        $base = $Traslado['Base'];
                                        $impuesto = $Traslado['Impuesto'];
                                        $tipoFactor = $Traslado['TipoFactor'];
                                        $tasaOCuota = $Traslado['TasaOCuota'];
                                        $ImporteImpuesto = $Traslado['Importe'];
                                        $base1[$a] = $base;
                                        $impuesto1[$a] = $impuesto;
                                        $tipoFactor1[$a] = $tipoFactor;
                                        $tasaOCuota1[$a] = $tasaOCuota;
                                        $ImporteImpuesto1[$a] = $ImporteImpuesto;
                                        ++$a;
                                    }
                                    $z = 0;
                                    foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto) {
                                        $Valorunitario = $Concepto["ValorUnitario"];
                                        $Importe = $Concepto["Importe"];
                                        $Descuento = $Concepto["Descuento"];
                                        $articulos .= '
                                            <tr> 
                                                <td>'.$Concepto["ClaveProdServ"].'</td> 
                                                <td class="left">'.$Concepto["Descripcion"].'</td>
                                                <td>'.$Concepto["Cantidad"].'</td> 
                                                <td>'.$Concepto["ClaveUnidad"].'</td>
                                                <td>'.number_format((float) $Valorunitario, 2).'</td>
                                                <td>'.number_format((float) $Importe, 2).'</td> 
                                                <td>'.number_format((float) $Descuento, 2).'</td> 
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Base:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$base1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Impuesto:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$impuesto1[$z].'</span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Tipo Factor:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$tipoFactor1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Tasa o Cuota:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$tasaOCuota1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span style="font-size:9px;">Importe Impuesto:</span>
                                                            </td>
                                                            <td>
                                                                <span style="font-size:9px;">'.$ImporteImpuesto1[$z].'</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>';
                                        ++$z;
                                    }
                                    $numeroSerSAT = "";
                                    $FechaTimbrado = "";
                                    $selloCFD = "";
                                    $UUID = "";
                                    //$Dompdf = new Dompdf();
                                    foreach ($xmlTimbrado->xpath('//t:TimbreFiscalDigital') as $Concepto) {
                                        $UUID = $Concepto["UUID"];
                                        $numeroSerSAT = $Concepto["NoCertificadoSAT"];
                                        $FechaTimbrado = $Concepto["FechaTimbrado"];
                                        $selloCFD = $Concepto["SelloCFD"];
                                    }
                                    $xdoc = new DomDocument();
                                    $xdoc->loadXML($xmd);
                                    $XSL = new DOMDocument();
                                    $XSL->load('cadenaoriginal_3_3.xslt');
                                    $proc = new XSLTProcessor;
                                    $proc->registerPHPFunctions();
                                    $proc->importStyleSheet($XSL);
                                    $CadenaOriginal = $proc->transformToXML($xdoc);
                                    $QR = "?re=".$Emisor."&rr=".$recRfc."&tt=".$UUID;
                                    #Datos para el PDF
                                    $matrixPointSize = 4;
                                    $TimbradoFecha = explode("T", $FechaTimbrado);
                                    if ($i == 1) //Inserta la factura Timbrada en SAP Dportenis Ingreso
                                    {
                                        //Descomentar es solo para prueba
                                        // $SapZmfCommx1033FactPortal = "SapZmfCommx1033FactPortal";
                                        // $SapZmfCommx1033FactPortal($Ticket, $documento, $UUID, $tipoDeComprobante, $TimbradoFecha);
                                    }
                                    if ($i == 2) //Inserta la factura Timbrada en SAP Dportenis Egreso
                                    {
                                        //Descomentar es solo para prueba
                                        // $SapZmfCommx1033FactPortal = "SapZmfCommx1033FactPortal";
                                        // $tipoDeComprobante = "E";
                                        // $SapZmfCommx1033FactPortal($Ticket, $documento, $UUID, $tipoDeComprobante, $TimbradoFecha);
                                    }
                                    #Convierto PDF, XML y QR
                                    if ($i == 1) {
                                        # code...
                                        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../QR/temp'.DIRECTORY_SEPARATOR;
                                        $PNG_WEB_DIR = '../QR/temp/';
                                        $filename = $PNG_TEMP_DIR.'tes'.$RFC.'.png';
                                        $errorCorrectionLevel = 'L';
                                        $filename = $PNG_TEMP_DIR.'test'.md5($QR.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                                        QRcode::png($QR, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                                        $imagen = base64_encode($PNG_WEB_DIR.basename($filename));
                                        // outputs image directly into browser, as PNG stream
                                        $SubTotal = number_format((float) $SubTotal, 2);
                                        $Importe = number_format((float) $Importe, 2);
                                        $total = number_format((float) $total, 2);
                                        if (! isset($pdf)) {
                                            require("DpStringPdf33.php");
                                            //require_once("DpStringPdf33.php");
                                        }
                                        $Dompdf = new Dompdf();
                                        $Dompdf->load_html($pdf);
                                        $Dompdf->set_paper('A4', 'portrait');
                                        $Dompdf->render();
                                        $pdfs = $Dompdf->output();
                                        file_put_contents("../Facturas/".$folio."_".$nContadorEntregas.".pdf", $pdfs);
                                        //file_put_contents("../Facturas/" . $folio . "_" . $nContadorEntregas . ".xml", $xmlTimbrado->asXml());
                                        file_put_contents("../Facturas/".$folio."_".$nContadorEntregas.".xml", $xmd);
                                        #Convierto PDF, XML y QR
                                        // Creamos un instancia de la clase ZipArchive
                                        $zip = new ZipArchive();
                                        // Creamos y abrimos un archivo zip temporal
                                        $zip->open("../Facturas/".$folio.".zip", ZipArchive::CREATE);
                                        // Añadimos un directorio
                                        $dir = "../Facturas/".$folio.".zip";
                                        // Añadimos un archivo en la raid del zip.
                                        $zip->addFile("../Facturas/".$folio."_".$nContadorEntregas.".pdf", "".$folio."_".$nContadorEntregas.".pdf");
                                        $Nombres = "".$folio."_".$nContadorEntregas.".pdf";
                                        $NombreAdjuntos[$nListadoAdjuntos] = $Nombres;
                                        $listadoNombre = "../Facturas/".$folio."_".$nContadorEntregas.".pdf";
                                        $ListaAdjuntos[$nListadoAdjuntos] = $listadoNombre;
                                        $nListadoAdjuntos++;
                                        $zip->addFile("../Facturas/".$folio."_".$nContadorEntregas.".xml", "".$folio."_".$nContadorEntregas.".xml");
                                        $Nombres = "".$folio."_".$nContadorEntregas.".xml";
                                        $NombreAdjuntos[$nListadoAdjuntos] = $Nombres;
                                        $listadoNombre = "../Facturas/".$folio."_".$nContadorEntregas.".xml";
                                        $ListaAdjuntos[$nListadoAdjuntos] = $listadoNombre;
                                        $nListadoAdjuntos++;
                                        // Una vez añadido los archivos deseados cerramos el zip.
                                        $zip->close();
                                        if ($nContadorEntregas == 0) {
                                            $res['data'] = [false, "fin caturas"];
                                        }
                                        // echo '
                                        //         <tr>
                                        //             <td>
                                        //                 <a href="Facturas/'.$folio."_".$nContadorEntregas.'.pdf" download="Facturas/'.$folio."_".$nContadorEntregas.'.pdf">
                                        //                 <img  class="image-responsive" src="img/pdf.png"></a>
                                        //             </td>
                                        //             <td>
                                        //                 <a download href="Facturas/'.$folio."_".$nContadorEntregas.'.xml" download="Facturas/'.$folio."_".$nContadorEntregas.'.xml">
                                        //                 <img  class="image-responsive" src="img/xml.png"></a>
                                        //             </td>
                                        //             <td><p></p></td>
                                        //         </tr>';

                                                $res['data'] = [false, '"Facturas/'.$folio."_".$nContadorEntregas.'.pdf"', '"Facturas/'.$folio."_".$nContadorEntregas.'.xml"'];
                                        unset($GLOBALS['pdf']);
                                        $nContadorEntregas++;
                                    } // Fin Ingreso
                                    else {
                                        if ($paso == 0) {
                                            // echo '<div class="alert alert-danger">
                                            //     <strong>ERROR!</strong> para poder realizar tu factura deberás esperar <b>24 hrs</b> 
                                            //     después de tu fecha de compra, Cualquier duda o aclaración favor de comunicarse al 
                                            //     66 99 15 53 00.</div>';

                                                $res['data'] = [false, "para poder realizar tu factura deberás esperar 24 hrs
                                                después de tu fecha de compra, Cualquier duda o aclaración favor de comunicarse al 
                                                66 99 15 53 00."];
                                            $paso++;
                                        }
                                        break;

                                        return;
                                    }
                                }
                            }
                        } //Fin for Ciclo genera factura Ingreso Egreso
                        $numXml++;
                    } // Fin else
                    foreach ($ListaAdjuntos as $value) {
                        $Lista2 .= $value."|";
                    }
                    foreach ($NombreAdjuntos as $value1) {
                        $NombreAd .= $value1."|";
                    }
                    if (count($ListaAdjuntos) > 0) {
                        foreach ($ListaAdjuntos as $value) {
                            $Lista2 .= $value."|";
                        }
                        foreach ($NombreAdjuntos as $value1) {
                            $NombreAd .= $value1."|";
                        }// </table> Revisar aocegueda
                        echo '
                                <tr>
                                    <td><p></p></td>
                                    <td><p></p></td>
                                    <td><img id="email"  class="image-responsive" src="img/email.png"></td>
                                </tr>
                                <input class="form-control" id="zip" type="submit"  style="display: none;" name="action" value="'.$Lista2.'">
                                <input class="form-control" id="namezip" type="submit" style="display: none;"  name="action" value="'.$NombreAd.'" >              
                                <div id="respuesta"></div>';
                             }
                         } // Fin foreach element
                  }
              }
         }
        } // Fin Try Principal
        catch (Exception $e) {
            error_log($e, 3, 'error_dp.log');
            $res['data'] = [false, "no se puede realizar la consulta de su ticket, intente mas tarde"];
            
        }

            //$res['data'] = $decoded;
               
            break;
        }
    echo json_encode($res);
    die();

















// if (! empty($Referencia)) {
//     $MetodoPagoTexto = $Referencia;
// } else {
//     $MetodoPagoTexto = "No identificado";
// }


?>