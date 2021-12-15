<?php 


$pdf='
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>
</head>

<body>';

$pdf.='
<div align="center">COMPROBANTE FISCAL DIGITAL
</div>
<p><img src="../Downloads/LogoDportenis.png" width="254" height="61" />
</p>
<table width="100%">
  <tr>
    <td colspan="2" bgcolor="#CCCCCC">DATOS FISCALES</td>
    <td width="11%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td colspan="2" bgcolor="#CCCCCC">DATOS TIMBRADOS&nbsp;&nbsp;&nbsp;  </td>
    <td width="23%">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%"><strong>Serie/Folio:</strong></td>
    <td width="22%">'.$folio.'</td>
    <td>Versión</td>
    <td>3.3</td>
    <td>&nbsp;</td>
    <td width="17%">Folio fiscal:</td>
    <td width="6%">&nbsp;</td>
    <td>'.$UUID.'</td>
  </tr>
  <tr>
    <td>Fecha comprobante:</td>
    <td>2019-02-21T16:30:33</td>
    <td>Forma de pago</td>
    <td>99</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Certificado No.:</td>
    <td>00001000000405329432</td>
    <td>Método de pago</td>
    <td>PUE</td>
    <td>&nbsp;</td>
    <td>F. Certif. CFDI:</td>
    <td>&nbsp;</td>
    <td>2019-02-21T17:30:38</td>
  </tr>
  <tr>
    <td>Tipo comprobante:</td>
    <td>E</td>
    <td>Moneda</td>
    <td>MXN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Lugar de expedición:</td>
    <td>60120</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%">
  <tr>
    <td colspan="2" align="center">EMISOR</td>
    <td colspan="2" align="center">RECEPTOR</td>
  </tr>
  <tr>
    <td>CDP9501269M5</td>
    <td>&nbsp;</td>
    <td>XAXX010101000</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Comercial Dportenis, SA de CV</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Régimen Fiscal</td>
    <td>601</td>
    <td>Uso de CFDI</td>
    <td>P01</td>
  </tr>
</table>

<div class="contenido">
   <div class="arriba">
    <div class="encabezado">
      <div class="Informacion1">
      <table border="0px">
      <tr>
        <td rowspan="2">Version: <br>'.$version.'</td>
        <td rowspan="2">Fecha: <br>'.$fecha.'</td>
        <td rowspan="2">Numero de certificado:<br>'.$noCertificado.'</td>
      </tr>
      <tr>
        <td ></td>
        <td ></td>
        <td ></td>      
      </tr>
      <tr>
        <td rowspan="2">Folio: <br>'.$folio.'</td>
        <td rowspan="2">Tipo: <br>'.$tipoDeComprobante.'</td>      
      </tr>
      <tr>
        <td ></td>
        <td ></td>
        <td ></td>      
      </tr>
      <tr>
        <td colspan="3">Regimen Fiscal:<br> REGIMEN GENERAL DE LEY PERSONAS MORALES</td>
      </tr>
      </table>
      </div>  
      <div class="Informacion2">
        <div class="cerieSAT">No.Certificado SAT: '.$numeroSerSAT.'</div>
        <div class="folioFiscal">Folio Fiscal: '.$UUID.'</div>
        <div class="fechaCertificado">Fecha Timbrado: '.$FechaTimbrado.'</div>
      </div>
    </div>

    <div class="dEmisor">
      <div class="cabezaemisor">
        <h4>DATOS DEL EMISOR</h4>
      </div>
        <table class="emisortabla">
          <tr>
            <td><b>RFC:</b>'.$RfcEmisor.'</td>
            <td><b>Nombre:</b>'.$nombre.'</td>
            <td><b>Regimen Fiscal:</b>'.$Regimen.'</td>
            <td></td>
          </tr>
          <tr>
          </tr>
        </table>    
    </div>

    <div class="dEmisor">
      <div class="cabezaemisor">
        <h4>DATOS DEL RECEPTOR</h4>
      </div>
        <table class="emisortabla">
          <tr>
            <td><b>RFC:</b>'.$recRfc.'</td>
            <td><b>Nombre:</b>'.$recNombre.'</td>
            <td><b>Uso CFDI:</b>'.$UsoCFDI.'</td>
            <td></td>
          </tr>
        </table>  
    </div>
  </div>';


  $pdf.='<div class="cuerpo">
      <div class="articulos">
        <table class="tabla">
          <thead>
          <tr>
            <th class="izq">ClaveProdServ</th>
            <th>Descripcion</th>
            <th>Unidad</th>
            <th>ClaveUnidad</th>
            <th>Precio Unitario</th>
            <th class="dere">Importe</th>
            <th class="dere">Descuento</th>
            <th>Traslado</th>
          </tr>
          </thead>
          '.$articulos.'
        </table>


    </div>
      <div class="totales">
        <p>SubTotal: $'.$SubTotal.' </p>
        <p>Total IVA: $'.$ImporteImpuesto.'</p>
        <p>Descuentos: $'.$descuento.'</p>
        <hr>
        <p>Total: $'.$total.'</p>
      </div>
  </div>
  ';


$pdf.='
 <div class="abajo">
    <div class="footer">
      <div class="divisor">
        <table class="emisortabla">
          <tr>
            <td><b>Forma de Pago:</b>'.utf8_encode($formaDePago).'</td>
            <td><b>Metodo de Pago:</b>'.utf8_encode($metodoDePago).'</td>
          </tr>
        </table>
      </div>
      <div class="tablafooter">
      <table  class="emisortabla"> 
      <tr>
      <td colspan="3">
                <div class="QR">
                  <img width="150px" src="'.$PNG_WEB_DIR.basename($filename).'">
                </div>
      </td>
      <td>
            <div class="timbre">
                <div class="cabezatimbre">
                  <h4>CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACION DIGITAL DEL SAT</h4>
                </div>
                <div class="texto">
                    <p>'.$CadenaOriginal.'</p>
                </div>
              </div>
        </td>
        </tr>
        </table>
    </div>

      <div class="creditos">
        <p>"ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI"</p>
      </div>
    </div>
  </div>  

</div>
</body>
</html>
';