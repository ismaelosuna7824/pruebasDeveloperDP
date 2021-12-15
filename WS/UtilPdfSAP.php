<?php
    //class UtilDP
    //{
        

        //function UtilDPnNueva()
        //{
          require_once ('../dompdf/autoload.inc.php');
          require_once ('../QR/qrlib.php');
          require_once ('DPWS/SapZmfFunction.php');
          require_once ('Login/wsfacturacion.php');
          use Dompdf\Dompdf;
          ob_start();  
          require_once '../dompdf/autoload.inc.php';

          /*$this->$distribuidor1 ="70082656";
        $this->$tda1= "V001";
        $this->*/
        $distribuidor1 ="70082503";
        $tda1= "T022";
        $xmd = '
<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd " Version="3.3" Descuento="275.69" Fecha="2020-10-23T11:53:00" Folio="0194838257" FormaPago="28" LugarExpedicion="82123" MetodoPago="PUE" Moneda="MXN" SubTotal="1378.45" TipoDeComprobante="I" Total="1279.20" Certificado="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" NoCertificado="00001000000405329432" Sello="UhMl8iJ1ou9fYK6np/BuFy4ySxAbHduLTulDAyj6QYta0JHKYwEdeZFopFc98xrXU5BizNpjRwBFleImFByvp2y2eSP7o6FEM7Vy49gl08BMkKJiKBlxhC3UqVsCtBK1JRBpoEB6x8bQ94o9k/LX9+mYdumIEJaIKH2kmJ8L375wyeotzBbJ4R0dqoEobq68QFGRg80jZpWGsacdOrvZOxd+3tbZvF4CLRrQLwSHIUxkMtN+oEg+asK/CXuQmHuEaIHA9AduZqvGyi0UiG4sM6KD0mrNyisdGZZhcYb8IMaCOUzZSwbgvZoN7i/iA8Uk/hjE2f1Q9Vr58hHMgFKVRQ==">
  <cfdi:Emisor Nombre="Comercial Dportenis, SA de CV" Rfc="CDP9501269M5" RegimenFiscal="601"/>
  <cfdi:Receptor Rfc="LOLR6611113JA" Nombre="RODOLFO LOPEZ LOPEZ" UsoCFDI="G03"/>
  <cfdi:Conceptos>
    <cfdi:Concepto ClaveProdServ="53111902" ClaveUnidad="H87" Cantidad="1.00" Descripcion="Folio: 1301201016194914 D JAPAN S, 25.0, Blanco/Azul Claro" ValorUnitario="1378.45" Importe="1378.45" Descuento="275.69">
      <cfdi:Impuestos>
        <cfdi:Traslados>
          <cfdi:Traslado Base="1102.76" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="176.4416"/>
        </cfdi:Traslados>
      </cfdi:Impuestos>
    </cfdi:Concepto>
  </cfdi:Conceptos>
  <cfdi:Impuestos TotalImpuestosTrasladados="176.44">
    <cfdi:Traslados>
      <cfdi:Traslado Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="176.44"/>
    </cfdi:Traslados>
  </cfdi:Impuestos>
  <cfdi:Complemento>
    <tfd:TimbreFiscalDigital xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" xsi:schemaLocation="http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd" Version="1.1" UUID="fdf6d57c-7e60-4b9b-a446-7747ddbccd99" FechaTimbrado="2020-10-23T12:53:03" RfcProvCertif="LSO1306189R5" SelloCFD="UhMl8iJ1ou9fYK6np/BuFy4ySxAbHduLTulDAyj6QYta0JHKYwEdeZFopFc98xrXU5BizNpjRwBFleImFByvp2y2eSP7o6FEM7Vy49gl08BMkKJiKBlxhC3UqVsCtBK1JRBpoEB6x8bQ94o9k/LX9+mYdumIEJaIKH2kmJ8L375wyeotzBbJ4R0dqoEobq68QFGRg80jZpWGsacdOrvZOxd+3tbZvF4CLRrQLwSHIUxkMtN+oEg+asK/CXuQmHuEaIHA9AduZqvGyi0UiG4sM6KD0mrNyisdGZZhcYb8IMaCOUzZSwbgvZoN7i/iA8Uk/hjE2f1Q9Vr58hHMgFKVRQ==" NoCertificadoSAT="00001000000408254801" SelloSAT="iDfU5QbxcEMvRpEdHFoLUQ4ImDtp1f6jDT/tnLO4A7LKoUQNO/nwVDV1PRfWL3wragbAhHO9rKehyN5+FipaU2MUssv9M7En2v3XdtTWi7HP6DdJBPyTs6/s8WBlitJiJ+rjrGwmEcKx2L5sxL3UqsK8c0xL+DPFhZpd+kuwR8gp2ZbMKx5ADPpipYU9MJPPS6Ig2GFCLmNw0EwG09EGJ0Sugy62QwQHqhU4IveZP4wDRagTrlE574hzIj1G3VDOX8I4aMC4gPf2VfoJR6aewSw5Nmd7TFyUh084dRd50AgBAb0kr8Mzu8ve0BSENpZGJmL1F1rv8iaOgqUbfXVB5A=="/>
  </cfdi:Complemento>
</cfdi:Comprobante>
';

          try //inicia Facturacion Dp
          {
            #Datos para el PDFc>
            //$xmlTimbrado = simplexml_load_string($xmd, 'SimpleXMLElement', LIBXML_NOCDATA);
            //echo '<pre>', htmlentities($xmd), '</pre>'; 
             //base64_decode($this->xmd1);
            $xmlTimbrado = simplexml_load_string(str_replace('encoding="UTF-8"', 'encoding="ISO-8859-1"', $xmd));
            $ns = $xmlTimbrado->getNamespaces(true);
            $xmlTimbrado->registerXPathNamespace('t', $ns['tfd']);
            //echo '<pre>', htmlentities($xmlTimbrado), '</pre>';  
            $folio="";
            $certificado="";
            $noCertificado ="";
            $version ="";
            $fecha  ="";
            $tipoDeComprobante  ="";
            $descuento  ="";
            $total  ="";
            $formaDePago  ="";
            $condicionesDePago  ="";
            $metodoDePago ="";
            $LugarExpedicion="";
            $NumCtaPago ="";
            foreach ($xmlTimbrado->xpath('//cfdi:Comprobante') as $cfdiComprobante)
            {
                $certificado= $cfdiComprobante['Certificado'];
                $noCertificado= $cfdiComprobante['NoCertificado'];
                $version= $cfdiComprobante['Version'];
                $folio= $cfdiComprobante['Folio'];
                $fecha = $cfdiComprobante['Fecha'];
                $tipoDeComprobante = $cfdiComprobante['TipoDeComprobante'];
                $descuento= $cfdiComprobante['Descuento'];
                $total= $cfdiComprobante['Total'];
                $formaDePago = $cfdiComprobante['FormaPago'];
                $condicionesDePago = $cfdiComprobante['condicionesDePago'];
                $metodoDePago= $cfdiComprobante['MetodoPago'];
                $LugarExpedicion = $cfdiComprobante['LugarExpedicion'];
                $Moneda = $cfdiComprobante['Moneda'];
                $SubTotal = $cfdiComprobante['SubTotal'];
            }
            $nombre="";
            $Emisor ="";
            foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor)
            {
                $nombre= $Emisor['Nombre'];
                $RfcEmisor= $Emisor['Rfc'];
                $Regimen= $Emisor['RegimenFiscal'];
            }
            #Variables Receptor
            $recNombre="";
            $recRfc="";
            foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor)
            {
                $recRfc= $Receptor['Rfc'];
                //echo "<br />";
                $recNombre = $Receptor['Nombre'];
                //echo "<br />";
                $UsoCFDI = $Receptor['UsoCFDI'];
                //echo "<br />";
            }
            #Variables Traslado
            $base="";
            $impuesto="";
            $ImporteImpuesto="";
            $relacionado="";
            $tipoFactor="";
            $tasaOCuota="";
            $base1[]="";
            $relacionado1[]="";
            $impuesto1[]="";
            $ImporteImpuesto1[]="";
            $tipoFactor1[]="";
            $tasaOCuota1[]="";
            #Variables Traslado
            $detallesPDF = '';
            $a=0;
            foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado)
            {
                $base = $Traslado['Base'];
                $impuesto = $Traslado['Impuesto'];
                $tipoFactor = $Traslado['TipoFactor'];
                $tasaOCuota = $Traslado['TasaOCuota'];
                $ImporteImpuesto = $Traslado['Importe'];
                $base1[$a] = $base;
                $impuesto1[$a] = $impuesto;
                $tipoFactor1[$a] =$tipoFactor;
                $tasaOCuota1[$a] = $tasaOCuota;
                $ImporteImpuesto1[$a] = $ImporteImpuesto;
                ++$a;
            }
            //$subtotal=0;
            $z=0;
            $m=0;
            $RElacionadoUUID="";
            foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados//cfdi:CfdiRelacionado') as $Relacionado)
            {
                $relacionado = $Relacionado['UUID'];
                $RElacionadoUUID.='
                        <table>
                            <tr>
                                <td>
                                    <span style="font-size:9px;">UUID Relacionado:</span>
                                </td>
                                <td>
                                    <span style="font-size:9px;">'.$relacionado.'</span>
                                </td>
                            </tr>
                        </table>
                    ';
                ++$m;
            }
            $articulos="";
            foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto)
            {
                $Valorunitario = $Concepto["ValorUnitario"];
                $Importe = $Concepto["Importe"];
                $Descuento = $Concepto["Descuento"];
                $articulos.='
                    <tr> 
                        <td>'.$Concepto["ClaveProdServ"].'</td> 
                        <td class="left">'.$Concepto["Descripcion"].'</td>
                        <td>'.$Concepto["Cantidad"].'</td> 
                        <td>'.$Concepto["ClaveUnidad"].'</td>
                        <td>'.number_format((float)$Valorunitario,2 ).'</td>
                        <td>'.number_format((float)$Importe,2).'</td> 
                        <td>'.number_format((float)$Descuento,2).'</td> 
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
                                        <span style="font-size:9px;">'.$impuesto[$z].'</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>';
                ++$z;
            }

            $numeroSerSAT="";
            $FechaTimbrado="";
            $selloCFD="";
            $UUID="";

            //$Dompdf = new Dompdf();
            foreach ($xmlTimbrado ->xpath('//t:TimbreFiscalDigital') as $Concepto)
            {
                $UUID=$Concepto["UUID"];
                $numeroSerSAT=$Concepto["NoCertificadoSAT"];
                $FechaTimbrado=$Concepto["FechaTimbrado"];
                $selloCFD=$Concepto["SelloCFD"];
            }
            
            $xdoc = new DomDocument();
            $xdoc->loadXML($xmd);
            $XSL = new DOMDocument();
            $XSL->load('cadenaoriginal_3_3.xslt');
            $proc = new XSLTProcessor;
            $proc->registerPHPFunctions();
            $proc->importStyleSheet($XSL);
            $CadenaOriginal = $proc->transformToXML($xdoc);
            $QR="?re=".$Emisor."&rr=".$recRfc."&tt=".$UUID;
            #Datos para el PDF
            $matrixPointSize = 4;
            $TimbradoFecha= explode("T", $FechaTimbrado);
            $nContadorEntregas = 0;
            #Convierto PDF, XML y QR
            # code...
            $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../QR/temp'.DIRECTORY_SEPARATOR;
            $PNG_WEB_DIR = '../QR/temp/';
            $filename = $PNG_TEMP_DIR.'tes'.$recRfc.'.png';
            $errorCorrectionLevel='L';
            $filename = $PNG_TEMP_DIR.'test'.md5($QR.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
            QRcode::png($QR, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            $imagen=base64_encode($PNG_WEB_DIR.basename($filename));
            // outputs image directly into browser, as PNG stream
            $SubTotal=number_format((float)$SubTotal,2);
            $Importe=number_format((float)$Importe,2);
            $total=number_format((float)$total,2);
            if(!isset($pdf))
            {
                require("../DpStringPDFSAP1.php");
                //require_once("DpStringPdf33.php");
            }

            $Dompdf = new Dompdf();
            $Dompdf->load_html($pdf);
            $Dompdf->set_paper('A4','portrait');
            $Dompdf->render();
            $pdfs = $Dompdf->output();
            file_put_contents("../Facturas/SAP/".$distribuidor1."_".$tda1.".pdf", $pdfs);
            //file_put_contents("../Facturas/SAP/".$folio."_".$nContadorEntregas.".xml", $xmd);
            #Convierto PDF, XML y QR
            
            if($nContadorEntregas==0)
            {
                echo "
                    <hr>
                        <table style='width:100%'>
                            <thead>
                                <tr>
                                    <th>PDF</th>
                                    <th>XML</th>
                                    <th>E-Mail</th>
                                </tr>
                            </thead>";
            }
            echo '
                <tr>
                    <td>
                        <a  href="Facturas/SAP/'.$UUID.'.pdf" download="Facturas/SAP/'.$UUID.'.pdf">
                            <img class="image-responsive" src="img/PDF.png"></a>
                    </td>
                    <td>
                        <p></p>
                    </td>';
            unset($GLOBALS['pdf']);
          } // Fin Try Principal 
          catch (Exception $e) 
          {
            error_log($e, 3, 'error_dp.log'); 
            echo "No se puede realizar la consulta de su tiquet Intente mas tarde".$e;
          }
        //}
    //}  
?>