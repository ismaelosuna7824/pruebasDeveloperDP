<?php 
  //set_time_limit(9000000000);
  $Ticket = $_POST["Ticket"];
  $T_RETORNO=1;
  require_once 'DPWS/SapZmfFunction.php';
  $SapZmfCommx1030Generaxmlportal="SapZmfCommx1030Generaxmlportal";
  $decoded=$SapZmfCommx1030Generaxmlportal($Ticket,$T_RETORNO);
	$mensajeValida = false;
  try 
  {
    $contador= count($decoded,COUNT_RECURSIVE);
    if ($contador < 4)
    {
      echo '<div class="alert alert-danger alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>ERROR!</strong> Folio del ticket incorrecto. <b>Ingrese</b> un folio válido.
            </div>';
      die();
    }
    else
    {
      $stringMensaje = "";
      if (array_key_exists('E_MENSAJE', $decoded["SapZmfCommx1030Generaxmlportal"])) 
      {
        $stringMensaje = $decoded["SapZmfCommx1030Generaxmlportal"]["E_MENSAJE"];
        //echo '<pre>', htmlentities($stringMensaje), '</pre>';
        if (strpos($stringMensaje, 'devolucion de todos los artículos') || strpos($stringMensaje, 'Ticket sin artículos pendientes'))
        {
          $mensajeValida = true;
          $stringMensaje = str_replace("01 800 0028 774", "66 99 15 53 00", $stringMensaje);
          echo "<div class='alert alert-danger' role='alert'>" . $stringMensaje . "</div>";
        }
        else
        {
          if(strpos($stringMensaje, 'folio de ticket contiene devoluciones de artículos'))
          {
            $mensajeValida = true;
            $stringMensaje = str_replace("01 800 0028 774", "66 99 15 53 00", $stringMensaje);
            echo "<div class='alert alert-danger' role='alert'>" . $stringMensaje . "</div>";
          }
          if (strpos($stringMensaje, 'devolucion de todos los artículos') == false) 
          {
            //echo $stringMensaje;
            if (array_key_exists('E_XML', $decoded["SapZmfCommx1030Generaxmlportal"])) 
            {
              $string= base64_decode($decoded["SapZmfCommx1030Generaxmlportal"]["E_XML"]);
              $findme = "</cfdi:Comprobante>";
              $pieces = explode($findme, $string);
              $numXml = 0;
              echo '<div class="table table-responsive">';
              foreach($pieces as $element)
              {
                $stringXML = (string)$pieces[$numXml] . '</cfdi:Comprobante>';
                if (strcasecmp($stringXML, '</cfdi:Comprobante>') == 0) {}
                else
                {
                  $xml = simplexml_load_string($stringXML, 'SimpleXMLElement', LIBXML_NOCDATA);
                  echo '<table class="table table-bordered font-xs">
                                  <thead class="thead-inverse">
                                    <tr>
                                      <th>Clave Prod.</th>
                                      <th>Descripción</th>
                                      <th>Cantidad</th>                                
                                      <th>Clave Unidad</th>
                                      <th>Valor Unitario</th>
                                      <th>Importe</th>
                                      <th>Descuento</th>
                                      <th>Traslado</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                  $i = 0;
                  $traslados = $xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado');
                  foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto)
                  {   
                    $Concepto["Traslado"] = $traslados[$i]["Importe"];
                    echo "<tr>";
                    echo "<td>".$Concepto["ClaveProdServ"]."</td>";
                    echo "<td>".$Concepto["Descripcion"]."</td>";
                    echo "<td>".$Concepto["Cantidad"]."</td>";
                    echo "<td>".$Concepto["ClaveUnidad"]."</td>";  
                    echo "<td>".$Concepto["ValorUnitario"]."</td>";  
                    echo "<td>".$Concepto["Importe"]."</td>"; 
                    echo "<td>".$Concepto["Descuento"]."</td>"; 
                    echo "<td>".$Concepto["Traslado"]."</td>"; 
                    echo "</tr>"; 
                    $i++;
                  }
                  echo "</tbody></table>";
                  $numXml++;
                }
              }
              echo '<center><input type="image" id="GenerarFactura" class="image-responsive" src="img/generar-factura.png"  /></center>';
            }            
            else
            {
              $stringMensaje = str_replace("01 800 0028 774", "66 99 15 53 00", $stringMensaje);
              echo '
                    <div class="alert alert-danger alert-dismissable fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        '.$stringMensaje.'
                      </div>';
                  echo "<p>
                    <hr NOSHADE size = 3 width=100%>
                  <p>";
                  die();              
              {
                $TicketFacturado="TicketFacturado";
                $valido = $TicketFacturado($Ticket);
                if ($valido->results >0) 
                {
                  echo '
                    <div class="alert alert-danger alert-dismissable fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Ticket Facturado!</strong> Folio del ticket ya ha sido Facturado anteriormente. <b>Ingrese</b> Folio Facturable.
                      </div>';
                  echo "<p>
                    <hr NOSHADE size = 3 width=100%>
                  <p>";
                  die();
                }
              }
            }
          }
          else
          {
            $string= base64_decode($decoded["SapZmfCommx1030Generaxmlportal"]["E_XML"]);
            //echo '<pre>', htmlentities($string), '</pre>';
            $findme = "</cfdi:Comprobante>";
            $pieces = explode($findme, $string);
            $numXml = 0;
            
            echo "<strong><h1><b>Artículos</b></h1></strong>";
            echo '<div class="table-responsive">';
            foreach($pieces as $element)
            {
              //echo '<pre>', htmlentities((string)$pieces[$numXml]), '</pre>';
              //$string = (string)$pieces[$numXml];
              //echo "string: " '<pre>', htmlentities($string), '</pre>';
              $stringXML = (string)$pieces[$numXml] . '</cfdi:Comprobante>';
              //echo '<pre>', htmlentities($stringXML), '</pre>';
              //$xml = simplexml_load_string((string)$pieces[$numXml], 'SimpleXMLElement', LIBXML_NOCDATA);
              if (strcasecmp($stringXML, '</cfdi:Comprobante>') == 0) {
              }
              else
              {
                $xml = simplexml_load_string($stringXML, 'SimpleXMLElement', LIBXML_NOCDATA);
                echo '<table class="table table-bordered">
                                <thead class="thead-inverse">
                                  <tr>
                                    <th>Clave Prod.</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad</th>                                
                                    <th>Clave Unidad</th>
                                    <th>Valor Unitario</th>
                                    <th>Importe</th>
                                    <th>Descuento</th>
                                  </tr>
                                </thead>
                                <tbody>';
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto)
                { 
                  echo "<tr>";
                  echo "<td>".$Concepto["ClaveProdServ"]."</td>";
                  // echo "<td>".$Concepto["ID"]."</td>";
                  echo "<td>".$Concepto["Descripcion"]."</td>";
                  echo "<td>".$Concepto["Cantidad"]."</td>";
                  echo "<td>".$Concepto["ClaveUnidad"]."</td>";  
                  echo "<td>".$Concepto["ValorUnitario"]."</td>";  
                  echo "<td>".$Concepto["Importe"]."</td>"; 
                  echo "<td>".$Concepto["Descuento"]."</td>"; 
                  echo "</tr>"; 
                }
                echo "</tbody></table>";
                $numXml++;
              }
            }
            echo '<center><input type="image" id="GenerarFactura" class="image-responsive" src="img/generar-factura.png"  /></center>';
          }
        }
      }// FIN Lee MEnsaje Respuesta
      else
      {
        if (array_key_exists('E_XML', $decoded["SapZmfCommx1030Generaxmlportal"])) 
        {
          $string= base64_decode($decoded["SapZmfCommx1030Generaxmlportal"]["E_XML"]);
          $findme = "</cfdi:Comprobante>";
          $pieces = explode($findme, $string);
          $numXml = 0;
          echo "<strong><h1><b>Artículos</b></h1></strong>";
          echo '<div class="table-responsive">';
          foreach($pieces as $element)
          {
            $stringXML = (string)$pieces[$numXml] . '</cfdi:Comprobante>';
            if (strcasecmp($stringXML, '</cfdi:Comprobante>') == 0) {}
            else
            {
              $xml = simplexml_load_string($stringXML, 'SimpleXMLElement', LIBXML_NOCDATA);
              echo '<table class="table table-bordered">
                              <thead class="thead-inverse">
                                <tr>
                                  <th>Clave Prod.</th>
                                  <th>Descripcion</th>
                                  <th>Cantidad</th>                                
                                  <th>Clave Unidad</th>
                                  <th>Valor Unitario</th>
                                  <th>Importe</th>
                                  <th>Descuento</th>
                                </tr>
                              </thead>
                              <tbody>';
              foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto)
              { 
                echo "<tr>";
                echo "<td>".$Concepto["ClaveProdServ"]."</td>";
                echo "<td>".$Concepto["Descripcion"]."</td>";
                echo "<td>".$Concepto["Cantidad"]."</td>";
                echo "<td>".$Concepto["ClaveUnidad"]."</td>";  
                echo "<td>".$Concepto["ValorUnitario"]."</td>";  
                echo "<td>".$Concepto["Importe"]."</td>"; 
                echo "<td>".$Concepto["Descuento"]."</td>"; 
                
              }
              $numXml++;
            }
          }
          echo "</tr></tbody></table>"; 
          echo '<center><input type="image" id="GenerarFactura" class="image-responsive" src="img/generar-factura.png"  /></center>';
        }            
        else
        {
          $TicketFacturado="TicketFacturado";
          $valido = $TicketFacturado($Ticket);
          if ($valido->results >0) 
          {
            echo '
              <div class="alert alert-danger alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Ticket Facturado!</strong> Folio del ticket ya ha sido Facturado anteriormente. <b>Ingrese</b> Folio Facturable.
                </div>';
            echo "<p>
              <hr NOSHADE size = 3 width=100%>
            <p>";
            die();
          }
        }
      }
    }
  } // FIN TRY CATCH
  catch (Exception $e) {
    echo "No se puede realizar la consulta de su tiquet Intente más tarde";
  }          
  
  if($mensajeValida == true){
    $stringMensaje = str_replace("01 800 0028 774", "66 99 15 53 00", $stringMensaje);
	  echo "<div class='alert alert-danger' role='alert'>" . $stringMensaje . "</div>";
  }
  else
  {
    if(empty($stringMensaje))
    {
      
    }
    else{
      $stringMensaje = str_replace("01 800 0028 774", "66 99 15 53 00", $stringMensaje);
      echo "<div class='alert alert-danger' role='alert'>" . $stringMensaje . "</div>"; 
    }
  }
?>