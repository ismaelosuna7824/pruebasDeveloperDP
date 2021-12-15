<?php
class Facturacion33{
    // object properties
    public $produccion;
    public $xmlb64;
// Timbra el CFDI
  function TimbrarB64(){
      // sanitize
      error_reporting(~(E_WARNING|E_NOTICE));
      error_reporting(0);
      //date_default_timezone_set('America/Mazatlan');
      date_default_timezone_set('America/Mexico_City');
      require_once '../sdk2.php';
      $this->produccion = strip_tags($this->produccion);
      $this->xmlb64 = strip_tags($this->xmlb64);
      $stringXML= base64_decode($this->xmlb64);
      $xmlstring = simplexml_load_string($stringXML, 'SimpleXMLElement', LIBXML_NOCDATA);
      //Se especifica la version de CFDi 3.3
      $datos['version_cfdi'] = '3.3';
      //Ruta del XML Timbrado
      $datos['cfdi']='../timbrados/cfdi_ejemplo_factura.xml';
      //Ruta del XML de Debug
      $datos['xml_debug']='../timbrados/sin_timbrar_ejemplo_factura.xml';
      if($this->produccion=='NO')
      {
      	//Credenciales del Timbrado
          $datos['PAC']['usuario'] = 'DEMO700101XXX';
          $datos['PAC']['pass'] = 'DEMO700101XXX';
          $datos['PAC']['produccion'] = (string)$this->produccion;
        
        //Rutas y clave de los CSD
          $datos['conf']['cer'] = '../certificados/XIA190128J61.cer.pem';
          $datos['conf']['key'] = '../certificados/XIA190128J61.key.pem';
          $datos['conf']['pass'] = '12345678a'; 
      }
      else
      {
      	foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
         $strRFC = (string)$Emisor['Rfc']; 
        }

        switch ($strRFC) 
	    {
	    case "CDP9501269M5":
	    //Credenciales del Timbrado
          $datos['PAC']['usuario'] = 'CDP9501269M5';
          $datos['PAC']['pass'] = 'Dp123!';
          $datos['PAC']['produccion'] = (string)$this->produccion;
        
        //Rutas y clave de los CSD
          $datos['conf']['cer'] = '../certificados/CSD_COMERCIAL_D_PORTENIS_SA_DE_CV_CD.cer';
          $datos['conf']['key'] = '../certificados/CSD_COMERCIAL_D_PORTENIS_SA_DE_CV_CD.key';
          $datos['conf']['pass'] = '2021CDPT1995'; 
	        break;
	    case "DDE950126QZ9":
	        //Credenciales del Timbrado
          $datos['PAC']['usuario'] = 'DDE950126QZ9';
          $datos['PAC']['pass'] = 'Dp123!';
          $datos['PAC']['produccion'] = (string)$this->produccion;
        
        //Rutas y clave de los CSD
          $datos['conf']['cer'] = '../certificados/CSD_DISTRIBUCIONES_DEPORTIVAS_SA_DE_CV.cer';
          $datos['conf']['key'] = '../certificados/CSD_DISTRIBUCIONES_DEPORTIVAS_SA_DE_CV.key';
          $datos['conf']['pass'] = '1980Gdpt'; 
	        break;
	    case "NIM010219HC9":
	        //Credenciales del Timbrado
          $datos['PAC']['usuario'] = 'NIM010219HC9';
          $datos['PAC']['pass'] = 'Dp123!';
          $datos['PAC']['produccion'] = (string)$this->produccion;
        
        //Rutas y clave de los CSD
          $datos['conf']['cer'] = '../certificados/CSD_NEGOCIOS_INTEGRALES_DE_MEXICO_SA_DE_CV.cer';
          $datos['conf']['key'] = '../certificados/CSD_NEGOCIOS_INTEGRALES_DE_MEXICO_SA_DE_CV.key';
          $datos['conf']['pass'] = '2001Gdpt'; 
	        break;
      case "FIN1811151J2":
          //Credenciales del Timbrado
          $datos['PAC']['usuario'] = 'FIN1811151J2';
          $datos['PAC']['pass'] = 'Dp123!';
          $datos['PAC']['produccion'] = (string)$this->produccion;
        
        //Rutas y clave de los CSD
          $datos['conf']['cer'] = '../certificados/CSD_FINDP_SAPI_DE_CV_FIN1811151J2.cer';
          $datos['conf']['key'] = '../certificados/CSD_FINDP_SAPI_DE_CV_FIN1811151J2.key';
          $datos['conf']['pass'] = 'FinGdpt2018'; 
          break;
	    default:
	        //Credenciales del Timbrado
          $datos['PAC']['usuario'] = 'CDP9501269M5';
          $datos['PAC']['pass'] = 'Dp123!';
          $datos['PAC']['produccion'] = (string)$this->produccion;
        
        //Rutas y clave de los CSD
          $datos['conf']['cer'] = '../certificados/CSD_COMERCIAL_D_PORTENIS_SA_DE_CV_CD.cer';
          $datos['conf']['key'] = '../certificados/CSD_COMERCIAL_D_PORTENIS_SA_DE_CV_CD.key';
          $datos['conf']['pass'] = '2021CDPT1995'; 
	    }
      }

          //Lee El comprobante
            foreach ($xmlstring->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
              
              $datos['factura']['condicionesDePago'] = (string)$cfdiComprobante['CondicionesDePago'];
                $datos['factura']['descuento'] = (string)$cfdiComprobante['Descuento'];
                $datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time());
                $datos['factura']['folio'] = (string)$cfdiComprobante['Folio']; 
                $datos['factura']['forma_pago'] = (string)$cfdiComprobante['FormaPago'];
                $datos['factura']['LugarExpedicion'] = (string)$cfdiComprobante['LugarExpedicion'];
                $datos['factura']['metodo_pago'] = (string)$cfdiComprobante['MetodoPago']; 
                $mone = (string)$cfdiComprobante['Moneda'];
                $datos['factura']['moneda'] = (string)$cfdiComprobante['Moneda'];   
                $datos['factura']['serie'] = (string)$cfdiComprobante['Serie'];
                $datos['factura']['subtotal'] = (string)$cfdiComprobante['SubTotal'];
                $datos['factura']['tipocomprobante'] = "E"; // I Ingeso E Egreso  N Nomina P Pago
                $datos['factura']['total'] = (string)$cfdiComprobante['Total'];
            }
            $count=0;
            foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados') as $CfdiRelacionados){
        		  $datos['CfdisRelacionados']['TipoRelacion'] = (string)$CfdiRelacionados["TipoRelacion"];
				      foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados//cfdi:CfdiRelacionado') as $CfdiRelacionado)
				      {
        			   if(!empty($xmlstring->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados//cfdi:CfdiRelacionado')[$count])) {
                      		$datos['CfdisRelacionados']['UUID'][$count] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados//cfdi:CfdiRelacionado')[$count]["UUID"];
                      		$count = $count + 1;
                }
            	}
            }
            //Lee El Emisor
            foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
                 $datos['emisor']['nombre'] = (string)$Emisor['Nombre']; 
                 if($this->produccion=='NO')
                    $datos['emisor']['rfc']= "XIA190128J61"; 
                 else
                    $datos['emisor']['rfc']= (string)$Emisor['Rfc']; 
                 $datos['factura']['RegimenFiscal'] = (string)$Emisor['RegimenFiscal'];
            } 

            //CFDIRelacionado
            foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados') as $CfdiRelacionados){ 
                 $datos['emisor']['nombre'] = (string)$Emisor['Nombre']; 
                 $datos['emisor']['rfc']= (string)$Emisor['Rfc']; 
            }

            //Lee El Receptor
            foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Receptor') as $ReceptorDomicilio){
                   $datos['receptor']['rfc']=(string)$ReceptorDomicilio['Rfc']; 
                   $datos['receptor']['nombre'] =(string)$ReceptorDomicilio['Nombre']; 
                   $datos['receptor']['UsoCFDI']=(string)$ReceptorDomicilio['UsoCFDI']; 
             }

            $count=0;
            foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){
                      $datos['conceptos'][$count]['ClaveProdServ'] = (string)$Concepto["ClaveProdServ"];
                      $datos['conceptos'][$count]['ClaveUnidad'] = (string)$Concepto["ClaveUnidad"];
                      $datos['conceptos'][$count]['ID'] = (string)$Concepto["NoIdentificacion"];
                      $datos['conceptos'][$count]['cantidad'] = (string)$Concepto["Cantidad"];
                      $datos['conceptos'][$count]['unidad'] = (string)$Concepto["Unidad"];
                      $datos['conceptos'][$count]['descripcion'] = (string)$Concepto["Descripcion"];
                      $datos['conceptos'][$count]['valorunitario'] = (string)$Concepto["ValorUnitario"];
                      $datos['conceptos'][$count]['importe'] = (string)$Concepto["Importe"];
                      $datos['conceptos'][$count]['Descuento'] = (string)$Concepto["Descuento"];
                      	if(!empty($xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:InformacionAduanera')[$count])) {
                      		$datos['conceptos'][$count]['InformacionAduanera'][0]['NumeroPedimento'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:InformacionAduanera')[$count]["NumeroPedimento"];
                      	}
                         if(!empty($xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado')[$count])) {
                             $datos['conceptos'][$count]['Impuestos']['Traslados'][0]['Base'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado')[$count]["Base"];
                             $datos['conceptos'][$count]['Impuestos']['Traslados'][0]['Impuesto'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado')[$count]["Impuesto"];
                             $datos['conceptos'][$count]['Impuestos']['Traslados'][0]['TipoFactor'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado')[$count]["TipoFactor"];
                             $datos['conceptos'][$count]['Impuestos']['Traslados'][0]['TasaOCuota'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado')[$count]["TasaOCuota"];
                             $datos['conceptos'][$count]['Impuestos']['Traslados'][0]['Importe'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado')[$count]["Importe"];
                         }
                      if(!empty($xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion')[$count])) {
                         $datos['conceptos'][$count]['Impuestos']['Retencion'][0]['Base'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion')[$count]["Base"];
                         $datos['conceptos'][$count]['Impuestos']['Retencion'][0]['Impuesto'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion')[$count]["Impuesto"];
                         $datos['conceptos'][$count]['Impuestos']['Retencion'][0]['TipoFactor'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion')[$count]["TipoFactor"];
                         $datos['conceptos'][$count]['Impuestos']['Retencion'][0]['TasaOCuota'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion')[$count]["TasaOCuota"];
                         $datos['conceptos'][$count]['Impuestos']['Retencion'][0]['Importe'] = (string)$xmlstring->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion')[$count]["Importe"];
                     }
                $count=$count+1;
            }

            // Lee Los impuestos del Comprobante
            foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $Impuestos){

                if(!empty($Impuestos['TotalImpuestosRetenidos'])){
                   $datos['impuestos']['TotalImpuestosRetenidos']=(string)$Impuestos['TotalImpuestosRetenidos'];
                }

                if(!empty($Impuestos['TotalImpuestosTrasladados'])){
                    $datos['impuestos']['TotalImpuestosTrasladados']=(string)$Impuestos['TotalImpuestosTrasladados'];
                }

                   foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $Retenciones){
                         $datos['impuestos']['retenciones'][0]['impuesto'] = (string)$Retenciones['Impuesto'];
                         $datos['impuestos']['retenciones'][0]['importe'] = (string)$Retenciones['Importe'];
                   }
                   $countT=0;
                   foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslados){
                         $datos['impuestos']['translados'][$countT]['impuesto'] =(string)$Traslados['Impuesto'];
                         $datos['impuestos']['translados'][$countT]['TipoFactor'] =(string)$Traslados['TipoFactor'];
                         $datos['impuestos']['translados'][$countT]['tasa'] =(string)$Traslados['TasaOCuota'];
                         $datos['impuestos']['translados'][$countT]['importe'] =(string)$Traslados['Importe'];
                   }
             }          
         // ESTO NO VIENE EN LA DOCUMENTAICON CHECARLO(PENDIENTE)

             $ns = $xmlstring ->getNamespaces(true);
            if (array_key_exists('pago10',$ns)) {
              $xmlstring ->registerXPathNamespace('p', $ns['pago10']);
              $countpago=0;
              foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Complemento//p:Pagos//p:Pago') as $PagoMaster){ 
                    $datos['complemento'] = 'pagos10';
                     //$datos['pagos10']['Pagos'][0]['FechaPago'] = (string)$PagoMaster['FechaPago']; 
                     $datos['pagos10']['Pagos'][0]['FechaPago'] = date('Y-m-d\TH:i:s', time());
                     $datos['pagos10']['Pagos'][0]['FormaDePagoP'] = (string)$PagoMaster['FormaDePagoP']; 
                     $datos['pagos10']['Pagos'][0]['MonedaP'] = (string)$PagoMaster['MonedaP']; 
                     $datos['pagos10']['Pagos'][0]['Monto']= (string)$PagoMaster['Monto']; 
                     $datos['pagos10']['Pagos'][0]['RfcEmisorCtaOrd'] = (string)$PagoMaster['RfcEmisorCtaOrd']; 
                     $datos['pagos10']['Pagos'][0]['CtaOrdenante'] = (string)$PagoMaster['CtaOrdenante']; 
                     $datos['pagos10']['Pagos'][0]['TipoCambioP']= (string)$PagoMaster['TipoCambioP'];

                    foreach ($xmlstring ->xpath('//cfdi:Comprobante//cfdi:Complemento//p:Pagos//p:Pago//p:DoctoRelacionado') as $pagodetalle ){
                        $datos['pagos10']['Pagos'][0]['DoctoRelacionado'][$countpago]['IdDocumento'] = (string)$pagodetalle["IdDocumento"];
                        $datos['pagos10']['Pagos'][0]['DoctoRelacionado'][$countpago]['MonedaDR'] = (string)$pagodetalle["MonedaDR"];
                        //$TipoCambioDR = $pagodetalle["TipoCambioDR"];
                        $datos['pagos10']['Pagos'][0]['DoctoRelacionado'][$countpago]['MetodoDePagoDR'] = (string)$pagodetalle["MetodoDePagoDR"];
                        $datos['pagos10']['Pagos'][0]['DoctoRelacionado'][$countpago]['NumParcialidad'] = (string)$pagodetalle["NumParcialidad"];
                        $datos['pagos10']['Pagos'][0]['DoctoRelacionado'][$countpago]['ImpSaldoAnt'] = (string)$pagodetalle["ImpSaldoAnt"];
                        $datos['pagos10']['Pagos'][0]['DoctoRelacionado'][$countpago]['ImpPagado'] = (string)$pagodetalle["ImpPagado"];
                        $datos['pagos10']['Pagos'][0]['DoctoRelacionado'][$countpago]['ImpSaldoInsoluto'] = (string)$pagodetalle["ImpSaldoInsoluto"];
                        $countpago=$countpago+1;
                    }
                  
               }
            }


            /*$nss = $xmlstring ->getNamespaces(true);
            if (array_key_exists('tfd',$nss)) {
            $xmlstring ->registerXPathNamespace('t', $nss['tfd']);
                foreach ($xmlstring ->xpath('//t:TimbreFiscalDigital') as $Concepto){
                           $Version = $Concepto["Version"];
                           $RfcProvCertif = $Concepto["RfcProvCertif"];
                           $UUID=$Concepto["UUID"];
                           $NoCertificadoSAT=$Concepto["NoCertificadoSAT"];
                           $SelloSAT = $Concepto["SelloSAT"];
                           $FechaTimbrado=$Concepto["FechaTimbrado"];
                           $selloCFD=$Concepto["SelloCFD"];
                } 
            }*/

     $res = mf_genera_cfdi($datos);

     return json_encode($res);   
  }

}