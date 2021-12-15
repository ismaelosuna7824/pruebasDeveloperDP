<?php

$RFC = $_POST["RFC"];
$Nombre = $_POST["Nombre"];
$ApellidoP = $_POST["ApellidoP"];

if (isset($_POST["ApellidoM"])) {
  $ApellidoM = $_POST["ApellidoM"];
}else{
  $ApellidoM="";
}

$Calle = $_POST["Calle"];
$NumeroEx = $_POST["NumeroEx"];
$NumeroInt = $_POST["NumeroInt"];
$Distrito = $_POST["Distrito"];
$CP= $_POST["CP"];
$Pais = $_POST["Pais"];   
$Region = $_POST["Region"]; 
$Telefono = $_POST["Telefono"];
$Email = $_POST["Email"];
$EstadoCivil = $_POST["EstadoCivil"];
$Sexo = $_POST["Sexo"];
$Ciudad = $_POST["Ciudad"];
$Ticket=$_POST["Ticket"];
$MetodoDePago=$_POST["MetodoPago"];
$MetodoPagoTexto= $_POST["MetodoPagoTexto"];
$Referencia = $_POST["Referencia"];
$MetodoDePago= $MetodoDePago." ".$MetodoPagoTexto;
$Ingreso="";
//$NumeroInt="213";
  if(!empty($Referencia)) {
    $MetodoPagoTexto=$Referencia;
  }else{
    $MetodoPagoTexto="No identificado";
  }

//$superString ="";
            require_once '../dompdf/autoload.inc.php';
            require_once '../QR/qrlib.php';
            require_once 'DPWS/SapZmfFunction.php';
            require_once 'Login/wsfacturacion.php';

            use Dompdf\Dompdf;
            $Dompdf = new Dompdf();


           $TicketFacturado="TicketFacturado";
           $valido=$TicketFacturado($Ticket);
           if ($valido["results"]>0) {
                echo '
                 <div class="alert alert-danger alert-dismissable fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Ticket Facturado!</strong> Folio del ticket ya ha sido Facturado anteriormente. <b>Ingrese</b> Folio Facturable.
                  </div>
                  ';
                  die();
           }
try {

  for ($i=1; $i <= 2 ; $i++) { 
        
           $T_RETORNO=1;
           //Consulto el Ticket
           $SapZmfCommx1030Generaxmlportal="SapZmfCommx1030Generaxmlportal";
           $decoded=$SapZmfCommx1030Generaxmlportal($Ticket,$T_RETORNO);

           $contador= count($decoded,COUNT_RECURSIVE);
    if ($contador<4){
              if ($i==1) {
                echo '
                 <div class="alert alert-danger alert-dismissable fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>ERROR!</strong> Folio del ticket incorrecto. <b>Ingrese</b> un folio valido.
                  </div>
                  ';
                // $superString.=" ERROR VUELTA 1 ";
                  die();
               }
               if ($i==2) {
                 // $superString.=" ERROR VUELTA 2 ";
                //  echo $superString= "No entra";
               }
      }else{

  #Lleno los campos del Receptor
              $string= base64_decode($decoded["SapZmfCommx1030Generaxmlportal"]["E_XML"]);
              if ($NumeroInt!="" || !empty($NumeroInt)) {
                              $string = str_replace('" codigoPostal', '" noInterior="" codigoPostal', $string);
              }
              $xml = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
              echo htmlentities($xml);
              $articulos="";
              $CadenaOriginal="";
              #Ingresar datos del Receptor
              if ($i==1) {
                # code...
              
              foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor')as $Receptor){ 
                $Receptor["rfc"] =$RFC;
                $Receptor["nombre"] =$Nombre." ".$ApellidoP." ".$ApellidoM;

              }

              foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $domicilio){ 
                  $domicilio["calle"] =$Calle;
                  $domicilio["noExterior"] =$NumeroEx;
                  $domicilio["colonia"]=$Distrito;
                  $domicilio["localidad"]=$Ciudad;
                  $domicilio["municipio"]=$Ciudad;
                  $domicilio["estado"]=$Region;
                  $domicilio["pais"]=$Pais;
                  $domicilio["codigoPostal"]=$CP;
                  if (isset($domicilio["noInterior"])) {
                    $domicilio["noInterior"] = $NumeroInt;
                  }
                  
                     /*               if ($NumeroInt !="" || !empty($NumeroInt)) {
                      $domicilio->setAttribute('noInterior',$NumeroInt);
                  }*/

              }
            }
            //noInterior
            if ($i==2) {                          
              foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor')as $Receptor){ 
                $Receptor["rfc"] ="XAXX010101000";
                $Receptor["nombre"] =$Nombre." ".$ApellidoP." ".$ApellidoM;
              }

              foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $domicilio){ 
                  $domicilio["calle"] =$Calle;
                  $domicilio["noExterior"] =$NumeroEx;
                  $domicilio["colonia"]=$Distrito;
                  $domicilio["localidad"]=$Ciudad;
                  $domicilio["municipio"]=$Ciudad;
                  $domicilio["estado"]=$Region;
                  $domicilio["pais"]=$Pais;
                  $domicilio["codigoPostal"]=$CP;
              }
            }
  #Lleno los campos del Receptor

  #LLeno los campos de metodo de pago

               foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
                if ($i==1) {
                 $cfdiComprobante['metodoDePago'] = $MetodoDePago;
                 $cfdiComprobante['NumCtaPago'] = $MetodoPagoTexto;
                }
                if ($i==2) {
                 $cfdiComprobante['metodoDePago'] = "99";
                 $cfdiComprobante['NumCtaPago'] = "No Identificado";
                }
               }
  #lleno los campos de metodo de pago        
            //Pido el numero de Entrega del Documento

            $documento='';
            foreach ($xml ->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Entregas//cfdi:Entrega') as $Entregas){ 
               $documento= $Entregas['documento']; 
            } 



              /*if ($NumeroInt !="" || !empty($numeroint)) {
              $xml->Comprobante->Receptor->Domicilio->addAttribute('noInterior', $NumeroInt );
              }*/

              $xmlstring = base64_encode($xml->asXml());

  #Timbrar XML
            if ($i==1) {
                    try {
                    $client = new SoapClient("https://arafacturacion.com/Dportenis/Service.asmx?WSDL");
                    //aocegueda
                    //$params = array('xml' => $xmlstring, 'produccion' => "1" ,"ticket" => $Ticket  );
                    $params = array('xml' => $xmlstring, 'produccion' => "0" ,"ticket" => $Ticket  );
                    $result = $client->FacturacionCliente($params);
                    $xmr=$result->FacturacionClienteResult;
                    } catch (Exception $e) {
                      error_log($e, 3, 'error_dp.log'); 
                      echo "Error al consultar".$e;
                    }
                              //   $superString.=" Pasa la primera ARA ";
            }

            if ($i==2) {
                try {
                $client = new SoapClient("https://arafacturacion.com/Dportenis/Service.asmx?WSDL");
                //aocegueda
                //$params = array('xml' => $xmlstring, 'produccion' => "1" ,"ticket" => $Ticket  );
                $params = array('xml' => $xmlstring, 'produccion' => "0" ,"ticket" => $Ticket  );
                $result = $client->FacturacionClienteEgreso($params);
                $xmr=$result->FacturacionClienteEgresoResult;
                } catch (Exception $e) {
                  error_log($e, 3, 'error_dp.log'); 
                  echo "Error al consultar".$e;
                }
             // $superString.=" Pasa la segunda ARA ";
            }
    
            //vuelta

            $findme   = '<error>';
            $pos = strpos($xmr, $findme);
            #Error al Timbrar
              if ($pos !== false) {
                       $vowels = array("<?xml version='1.0'?>", "<error>", "</error>", "</xml>");
                       $onlyconsonants = str_replace($vowels, "", $xmr);
                       if ($i==1) {
                       echo '
                           <div class="alert alert-danger alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>ERROR!</strong>'.$onlyconsonants.' ERROR .
                            </div>';  
                       die();
                     }
              }
            #Error al Timbrar
 

            $vowels = array("<?xml version='1.0'?>", "<xmlBase64>", "</xmlBase64>", "</xml>");
            $onlyconsonants = str_replace($vowels, "", $xmr);
            $xmd = base64_decode($onlyconsonants);
  #Timbrar XML   
  if ($i==1) {
          if (empty($xmd)||$xmd=='') {

                   echo '
               <div class="alert alert-danger alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>ERROR!</strong> Folio del ticket incorrecto. <b>Ingrese</b> un folio valido.
                </div>';      
            die();
  }


  #Datos para el PDF
                $xmlTimbrado = simplexml_load_string($xmd,'SimpleXMLElement', LIBXML_NOCDATA);
                $ns = $xmlTimbrado ->getNamespaces(true);
                $xmlTimbrado ->registerXPathNamespace('t', $ns['tfd']);
}

if ($i==2) {
                $xmlTimbrado = simplexml_load_string($xmd,'SimpleXMLElement', LIBXML_NOCDATA);
                $ns = $xmlTimbrado ->getNamespaces(true);
                $xmlTimbrado ->registerXPathNamespace('t', $ns['tfd']);
}
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

                foreach ($xmlTimbrado->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
                  $certificado= $cfdiComprobante['certificado'];   
                  $noCertificado= $cfdiComprobante['noCertificado'];  
                  $version= $cfdiComprobante['version'];  
                  $folio= $cfdiComprobante['folio'];  
                  $fecha= $cfdiComprobante['fecha']; 
                  $tipoDeComprobante = $cfdiComprobante['tipoDeComprobante']; 
                  $descuento= $cfdiComprobante['descuento']; 
                  $total= $cfdiComprobante['total'];   
                  $formaDePago= $cfdiComprobante['formaDePago']; 
                  $condicionesDePago = $cfdiComprobante['condicionesDePago']; 
                  $metodoDePago= $cfdiComprobante['metodoDePago'];   
                  $LugarExpedicion = $cfdiComprobante['LugarExpedicion']; 
                  $NumCtaPago = $cfdiComprobante['NumCtaPago'];       
                }
                     // foreach ($xmlTimbrado->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
                $nombre="";
                $Emisor ="";
                $emisorCalle="";
                $emisorNoExterior="";
                $emisorColonia="";
                $emisorLocalidad="";
                $emisorMunicipio="";
                $emisorPais="";
                $emisorCP="";
                foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
                 $nombre= $Emisor['nombre']; 
                 $Emisor= $Emisor['rfc']; 
                } 

                foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:DomicilioFiscal') as $DomicilioFiscal){ 
                   $emisorCalle= $DomicilioFiscal['calle']; 
                   $emisorNoExterior= $DomicilioFiscal['noExterior']; 
                   $emisorColonia= $DomicilioFiscal['colonia']; 
                   $emisorLocalidad= $DomicilioFiscal['localidad']; 
                   $emisorMunicipio = $DomicilioFiscal['municipio']; 
                   $emisorPais= $DomicilioFiscal['pais']; 
                   $emisorCP= $DomicilioFiscal['codigoPostal']; 
                } 



                #Variables ExpedidoEN
                    $excalle="";
                    $exnumero="";
                    $excolonia="";
                    $exlocalidad="";
                    $exmunicipio="";
                    $esestado="";
                    $expais="";
                    $exCP="";
                #Variables ExpedidoEN
                foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:ExpedidoEn') as $ExpedidoEn){ 
                   $excalle = $ExpedidoEn['calle']; 
                   $exnumero= $ExpedidoEn['noExterior']; 
                   $excolonia = $ExpedidoEn['colonia']; 
                   $exlocalidad= $ExpedidoEn['localidad']; 
                   $exmunicipio= $ExpedidoEn['municipio']; 
                   $esestado= $ExpedidoEn['estado']; 
                    $expais= $ExpedidoEn['pais']; 
                     $exCP= $ExpedidoEn['codigoPostal']; 
                } 

                #Variables Receptor
                  $recNombre="";
                  $recRfc="";
                  $recCalle="";
                  $recColonia="";
                  $recLocalidad="";
                  $recMunicipio="";
                  $recEstado="";
                  $recPais="";
                  $recNoInterior="";
                  $recNoInterior2="";
                  $recCP="";
                #Variables Receptor

                foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
                   $recRfc= $Receptor['rfc']; 
                   echo "<br />"; 
                   $recNombre= $Receptor['nombre']; 
                   echo "<br />"; 
                } 

                foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $ReceptorDomicilio){ 
                   $recCalle= $ReceptorDomicilio['calle']; 
                   $recColonia= $ReceptorDomicilio['colonia']; 
                   $recLocalidad= $ReceptorDomicilio['localidad']; 
                   $recMunicipio= $ReceptorDomicilio['municipio']; 
                   $recEstado= $ReceptorDomicilio['estado']; 
                   $recPais= $ReceptorDomicilio['pais']; 
                   $recNoInterior= $ReceptorDomicilio['noExterior']; 
                   $recCP=$ReceptorDomicilio['codigoPostal']; 
                   if (isset($ReceptorDomicilio['noInterior'])) {
                     $recNoInterior2 = $ReceptorDomicilio['noInterior'];                     
                   }
                } 

                #Variables Traslado
                  $impuesto="";
                  $importe="";
                #Variables Traslado

                foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
                   $impuesto= $Traslado['impuesto']; 
                   $importe= $Traslado['importe']; 
                }

                $subtotal=0;
                      foreach ($xmlTimbrado ->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){
                      $subtotal=(float)$subtotal+(float)$Concepto["importe"];
                      $Cantidad=$Concepto["cantidad"];
                      $unidad = $Concepto["unidad"];
                      $desc =$Concepto["descripcion"];
                      $valorUnitario = $Concepto["valorUnitario"];
                      $articulos.='<tr> 
                      <td>'.$Concepto["cantidad"].'</td> 
                      <td>'.$Concepto["unidad"].'</td>
                      <td class="left">'.$Concepto["descripcion"].'</td> 
                      <td>'.number_format((float)$Concepto["valorUnitario"],2 ).'</td>
                      <td>'.number_format((float)$Concepto["importe"],2).'</td> 
                      </tr>'; 
                      } 

                      $numeroSerSAT="";
                      $FechaTimbrado="";
                      $selloCFD="";
                      $UUID="";
                      foreach ($xmlTimbrado ->xpath('//t:TimbreFiscalDigital') as $Concepto){
                           $UUID=$Concepto["UUID"];
                           $numeroSerSAT=$Concepto["noCertificadoSAT"];
                           $FechaTimbrado=$Concepto["FechaTimbrado"];
                           $selloCFD=$Concepto["selloCFD"];
                      } 

                      $CadenaOriginal="**||".$version."|".$fecha."|".$tipoDeComprobante."|".$formaDePago."|".$condicionesDePago."|".$subtotal."|".$descuento."|".$total."|".$metodoDePago."|".$LugarExpedicion."|".$NumCtaPago."|".$Emisor."|".$nombre."|".$emisorCalle."|".$emisorNoExterior."|".$emisorColonia."|".$emisorLocalidad."|".$emisorMunicipio."|".$emisorPais."|".$emisorCP."|".$excalle."|".$exnumero."|".$excolonia."|".$exlocalidad."|".$exmunicipio."|".$expais."|".$exCP."|".$recRfc."|".$recNombre."|".$recCalle."|".$recNoInterior."|".$recColonia."|".$recLocalidad."|".$recMunicipio."|".$recEstado."|".$recEstado."|".$recPais."|".$recCP."|".$Cantidad."|".$unidad."|".$desc."|".$importe."|".$valorUnitario."|".$importe."||";
                      



                      $QR="?re=".$Emisor."&rr=".$recRfc."&tt=".$UUID;
  #Datos para el PDF                   
                $matrixPointSize = 4;

            

            
          $TimbradoFecha= explode("T", $FechaTimbrado);

/*
Antes de modificar
            $SapZmfCommx1033FactPortal="SapZmfCommx1033FactPortal";
            $SapZmfCommx1033FactPortal($Ticket,$documento,$UUID,$TimbradoFecha); 
            */
          //Inserta la factura Timbrada
          //aocegueda
          /*if ($i==1) {
            $SapZmfCommx1033FactPortal="SapZmfCommx1033FactPortal";
            $SapZmfCommx1033FactPortal($Ticket,$documento,$UUID,$tipoDeComprobante,$TimbradoFecha);   
          }
          if ($i==2) {
           $SapZmfCommx1033FactPortal="SapZmfCommx1033FactPortal";
            $tipoDeComprobante="Egreso";
            $SapZmfCommx1033FactPortal($Ticket,$documento,$UUID,$tipoDeComprobante,$TimbradoFecha);  
          }*/



  #Convierto PDF, XML y QR    
  if ($i==1) {
            # code...
       
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../QR/temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = '../QR/temp/';
    $filename = $PNG_TEMP_DIR.'tes'.$RFC.'.png';
               
    $errorCorrectionLevel='L';
    $filename = $PNG_TEMP_DIR.'test'.md5($QR.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($QR, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    $imagen=base64_encode($PNG_WEB_DIR.basename($filename));
    // outputs image directly into browser, as PNG stream 
  

        $subtotal=number_format((float)$subtotal,2);
        $importe=number_format((float)$importe,2);
        $total=number_format((float)$total,2);

            require_once("DpStringPdf.php");
            $Dompdf->set_paper('A4','portrait');
            $Dompdf->load_html(utf8_encode($pdf));

            $Dompdf->render();        
            $pdfs = $Dompdf->output();
            file_put_contents("../Facturas/PDF".$folio.".pdf", $pdfs);
            file_put_contents("../Facturas/XML".$folio.".xml", utf8_encode($xmlTimbrado->asXml()));
  #Convierto PDF, XML y QR           
         

            echo '
            <center>
            <table>
            <tr>
            <td>
            <a href="Facturas/PDF'.$folio.'.pdf" download="Facturas/PDF'.$folio.'.pdf">
            <img  class="image-responsive" width="200" src="imgRecurso/pdf.png"></a></td>

            <td><center><a  href="Facturas/XML'.$folio.'.xml" download="Facturas/XML'.$folio.'.xml"><img  class="image-responsive" width="200" src="imgRecurso/xml.png"></a></td>

            <td><img id="email"  class="image-responsive" width="200" src="imgRecurso/email.png"></td>
            </tr>
            </table>
            <input class="form-control" id="xml" type="text"  style="display: none;" name="idcliente" value="../Facturas/XML'.$folio.'.xml" >

            <input class="form-control" id="namepdf" type="text" style="display: none;"  name="idcliente" value="PDF'.$folio.'.pdf" >

            <input class="form-control" id="pdf" type="text" style="display: none;" name="idcliente" value="../Facturas/PDF'.$folio.'.pdf" >

            <input class="form-control" id="namexml" type="text" style="display: none;"  name="idcliente" value="XML'.$folio.'.xml" >
            
            <div id="respuesta">

            </div>

            </center>
            </center>';


        }
     }
  }
} catch (Exception $e) {
            error_log($e, 3, 'error_dp.log'); 
               echo "No se puede realizar la consulta de su tiquet Intente mas tarde".$e;
}          

  