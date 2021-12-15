<?php 


$pdf='
<!DOCTYPE html>
<html>
<head>
  <title>Facturacion DP</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
      background-image: url(../img/header.png);
      background-repeat: no-repeat;
      background-size: contain;
      background-position: 50% 50%;
      position: relative;
      width: 100%;
      height: 150px;
      color: white;  
     }

     table td.left{
      text-align: left
     }
     .Informacion1{
      font-size: 50%;
      font-family: Arial, Helvetica, sans-serif;
      position: relative;
      left: 35%;
      top:5%;
      color: white;
     }

     .Informacion2{
      font-size: 50%;
      font-family: Arial, Helvetica, sans-serif;
      position: relative;
      top: 3%;
      right: 1%;
      margin-left:70%;
      color: white;
      float: right;
     }  

     .dEmisor{
      position: relative;
      margin-top: 1%;
      width: 100%;
      background: #c5c5c5;

     }

     .cabezaemisor{
        position: relative;
        top:0px;
        width: 100%;
        background: #000000;
        text-align: center;
        color: white;
      }

      .divisor{
        position: relative;
        width: 100%;
        background: #c5c5c5;
      }

       .en{
        margin-left: 0%;
       }


     .cuerpo{
        width: 100%;
        margin-top: 2%;
        background: white;
     }

     .table td #alings{
        text-align: left !important;
     }

     .articulos{
        position: relative;
        width: 100%;
        margin-top: 1%;
        background: #c5c5c5;
     }

     .tablaem {
      width: 100%;
      background: blue;
     }

     .tablafooter{
      width: 100%;
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
     .totales{
      position: relative;
      color: white;
      background: #000000; 
      width: 250px;   
      margin-left:65%;
     }

    .QR{
      position: relative;
      color: white;
      margin-top: 0%;
      width: 100px;   
      right:  -5%;
     }

    .timbre{
      position: relative;
      color: white;
      background: #c5c5c5; 
      width: 545px;   
      right: 0%;
      margin-top: 0%;

     }
     .creditos{
      width: 100%;
      margin-top: 5%;
      text-align: center;   
     }

      .cabezatimbre{
      position: relative;
      width: 100%;
      background: #000000;
      text-align: center;
      color: white;

      }

      .texto{
        position: relative;
        color: black;
        margin-top: 0%;
      }
      
      .texto p{
      word-wrap: break-word;
      }

     thead{
      color: white;
      background: #000000;
     }
     .tabla td{
      text-align: center;
      color: black;
     }
     .abajo{
      width: 100%;
      margin-top: 0%;
     }
     .footer{
      position: relative;
      width: 100%;
      margin-top: 2%;
      background: white;
     }

  </style>
</head>
<body>';

$pdf.='
<div class="contenido">
   <div class="arriba">
    <div class="encabezado">
      <div class="Informacion1">
      <table border="0px">
      <tr>
        <td rowspan="2">Version: <br>'.$version.'</td>
        <td rowspan="2">Fecha: <br>'.$fecha.'</td>
        <td rowspan="2">Numero de sertificado:<br>'.$noCertificado.'</td>
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
            <td><b>RFC:</b>'.utf8_encode($Emisor).'</td>
            <td><b>Nombre:</b>'.utf8_encode($nombre).'</td>
            <td ><b>Direccion:</b>'.utf8_encode($emisorCalle).' '.utf8_encode($emisorNoExterior).' '.utf8_encode($emisorColonia).'</td>
            <td></td>
          </tr>
          <tr>
            <td><b>Municipio:</b>'.utf8_encode($emisorMunicipio).'</td>
            <td><b>Localidad:</b>'.utf8_encode($emisorLocalidad).'</td>
            <td><b>C.P:</b>'.$emisorCP.'</td>
            <td><b>Pais:</b>'.$emisorPais.'</td>
          </tr>
        </table>    
    </div>

    <div class="dEmisor">
      <div class="cabezaemisor">
        <h4 class="en">EXPEDIDO EN</h4>
      </div>      
          <table class="emisortabla">
          <tr>
            <td><b>Direccion:</b>'.utf8_encode($excalle).' '.utf8_encode($exnumero).' '.utf8_encode($excolonia).' '.utf8_encode($exlocalidad).'</td>
            <td><b>Municipio:</b>'.utf8_encode($exmunicipio).'</td>
            <td><b>Estado:</b>'.utf8_encode($esestado).'</td>
          </tr>
          <tr>
            <td><b>C.P:</b>'.$exCP.'</td>
            <td><b>Pais:</b>'.$expais.'</td>
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
            <td><b>Nombre:</b>'.utf8_encode($recNombre).'</td>
            <td ><b>Direccion:</b>'.utf8_encode($recCalle).' '.utf8_encode($recNoInterior).' '.utf8_encode($recNoInterior2).' '.utf8_encode($recColonia).' '.utf8_encode($recLocalidad).'</td>
            <td></td>
          </tr>
          <tr>
            <td><b>Municipio:</b>'.utf8_encode($recMunicipio).'</td>
            <td><b>Estado:</b> '.utf8_encode($recEstado).'</td>
            <td><b>C.P:</b> '.$recCP.'</td>
            <td><b>Pais:</b> '.utf8_encode($recPais).'</td>
          </tr>
        </table>  
    </div>
  </div>';


  $pdf.='<div class="cuerpo">
      <div class="articulos">
        <table class="tabla">
          <thead>
          <tr>
            <th class="izq">Cantidad</th>
            <th>Unidad</th>
            <th>Descripcion</th>
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
        <p>SubTotal: $'.$subtotal.' </p>
        <p>'.$impuesto.': $'.$importe.'</p>
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
            <td><b>Cuenta de Pago:</b>'.utf8_encode($NumCtaPago).'</td>
            <td><b>Metodo de Pago:</b>'.utf8_encode($metodoDePago).'</td>
            <td><b>Forma de Pago:</b>'.utf8_encode($formaDePago).'</td>
            <td><b>Condiciones:</b>'.utf8_encode($condicionesDePago).'</td>

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