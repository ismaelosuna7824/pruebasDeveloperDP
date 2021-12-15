<?php 


$pdf='
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Factura GrupoDP desde SAP</title>
  <style type="text/css">
    .contenido{
    width: 100%;
    background: white;
    margin: 0 auto;
    }
    body{
      font-size: 70%;
      font-family: Arial, Helvetica, sans-serif;
    }
    .encabezado{
      background-image: url(../img/LogoDp1.png);
      background-repeat: no-repeat;
      background-size: contain;
      position: relative;
      width: 100%;
      height: 150px; 
     }
     .QR{
      position: relative;
      color: white;
      margin-top: 0%;
      width: 100px;   
      right:  -5%;
     }
     .creditos{
      width: 100%;
      margin-top: 5%;
      text-align: center;   
     }
     .emisortabla{
      position: relative;
      width: 100%;
      margin-top: 0%;
     }

     .tabla{
      margin-top: 0%;
      border-color: white;
      border:1px solid white;
      border-collapse: collapse;
      width: 100%;

     }
     .timbre{
      position: relative;
      width: 545px;   
      right: 0%;
      margin-top: 0%;

     }
     .texto{
        position: relative;
        color: black;
        margin-top: 0%;
      }
      table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
}
th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
}
      .headt td {
  min-width: 235px;
  height: 100px;
}
  </style>
</head>

<body>';

$pdf.='
<div class="encabezado"></div>
<table class="emisortabla">
  <tr>
    <th colspan="5" bgcolor="#CCCCCC">DATOS FISCALES</th>
    
    <th colspan="4" bgcolor="#CCCCCC">DATOS TIMBRADOS</th>
    
  </tr>
  <tr>
    <td><span style="font-size:9px;"><strong>Serie/Folio:</strong></td>
    <td><span style="font-size:9px;">'.$folio.'</td>
    <td><span style="font-size:9px;"><strong>Versión:</strong></td>
    <td><span style="font-size:9px;">'.$version.'</td>
    <td>&nbsp;</td>
    <td align="right"><span style="font-size:9px;"><strong>Folio fiscal:</strong></td>
    <td >&nbsp;</td>
    <td><span style="font-size:9px;">'.$UUID.'</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span style="font-size:9px;"><strong>Fecha comprobante:</strong></td>
    <td><span style="font-size:9px;">'.$fecha.'</td>
    <td><span style="font-size:9px;"><strong>Forma de pago:</strong></td>
    <td><span style="font-size:9px;">'.utf8_encode($formaDePago).'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span style="font-size:9px;"><strong>Certificado No.:</strong></td>
    <td><span style="font-size:9px;">'.$noCertificado.'</td>
    <td><span style="font-size:9px;"><strong>Método de pago:</strong></td>
    <td><span style="font-size:9px;">'.utf8_encode($metodoDePago).'</td>
    <td>&nbsp;</td>
    <td align="right"><span style="font-size:9px;"><strong>F. Certif. CFDI:</strong></td>
    <td>&nbsp;</td>
    <td><span style="font-size:9px;">'.$FechaTimbrado.'</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span style="font-size:9px;"><strong>Tipo comprobante:</strong></td>
    <td><span style="font-size:9px;">'.$tipoDeComprobante.'</td>
    <td><span style="font-size:9px;"><strong>Moneda:</strong></td>
    <td><span style="font-size:9px;">MXN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span style="font-size:9px;"><strong>Lugar de expedición:</strong></td>
    <td><span style="font-size:9px;">85000</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%">
  <tr>
    <th colspan="2" align="center" bgcolor="#CCCCCC">EMISOR</th>
    <th colspan="2" align="center" bgcolor="#CCCCCC">RECEPTOR</th>
  </tr>
  <tr>
    <td><span style="font-size:9px;">'.$RfcEmisor.'</td>
    <td>&nbsp;</td>
    <td><span style="font-size:9px;">'.$recRfc.'</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span style="font-size:9px;">'.$nombre.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span style="font-size:9px;">Régimen Fiscal        '.$Regimen.'</td>
    <td>&nbsp;</td>
    <td><span style="font-size:9px;">Uso de CFDI    '.$UsoCFDI.'</td>
    <td>&nbsp;</td>
  </tr>
</table>';


  $pdf.='
  <table width="100%" border="0">
  <tr>
    <th bgcolor="#CCCCCC" scope="col">Clave Prod.</th>
    <th bgcolor="#CCCCCC" scope="col">No Identicicación</th>
    <th bgcolor="#CCCCCC" scope="col">Descripción</th>
    <th bgcolor="#CCCCCC" scope="col">Cantidad</th>
    <th bgcolor="#CCCCCC" scope="col">Clave Unidad</th>
    <th bgcolor="#CCCCCC" scope="col">Valor Unitario</th>
    <th bgcolor="#CCCCCC" scope="col">Importe</th>
    <th bgcolor="#CCCCCC" scope="col">Descuento</th>
  </tr>
  '.$articulos.'
</table>
<table width="100%" border="0">
  <tr>
    <th bgcolor="#CCCCCC" scope="col">CFDI Relacionados</th>
    <th scope="col">&nbsp;</th>
  </tr>
  '.$RElacionadoUUID.'
</table>
<table border="0">
      <tr>
        <th colspan="2" align="left" bgcolor="#CCCCCC" scope="col">Totales</th>
        <th></th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td><span style="font-size:9px;"><strong>Subtotal</strong></td>
        <td><span style="font-size:9px;">$'.$SubTotal.'</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td><span style="font-size:9px;"><strong>Desglose de impuestos trasladados</strong></td>
        <td><span style="font-size:9px;"><strong>Total IVA</strong></td>
        <td><span style="font-size:9px;">$'.$ImporteImpuesto.'</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td><span style="font-size:9px;"><strong>Descuentos</strong></td>
        <td><span style="font-size:9px;">$'.$descuento.'</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td><span style="font-size:9px;"><strong>TOTAL</strong></td>
        <td><span style="font-size:9px;">$'.$total.'</td>
        <td></td>
      </tr>
  </table>
  ';


$pdf.='
<table  class="emisortabla"> 
  <tr>
    <td colspan="3">
      <div class="QR">
        <img width="150px" src="'.$PNG_WEB_DIR.basename($filename).'">
      </div>
    </td>
    <td>
      <div class="timbre">
        <div class="texto">
          <h4>Cadena original del complemento de certificación</h4>
          <p><span style="font-size:9px;">'.$CadenaOriginal.'</p>
        </div>
        <div class="texto">
          <h4>Sello digital emisor</h4>
          <p><span style="font-size:9px;">'.$selloCFD.'</p>
        </div>
        <div class="texto">
          <h4>Sello digital del SAT</h4>
          <p><span style="font-size:9px;">'.$numeroSerSAT.'</p>
        </div>
      </div>
    </td>
  </tr>
</table>
<div class="creditos">
  <p>"ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI"</p>
</div>
</body>
</html>
';