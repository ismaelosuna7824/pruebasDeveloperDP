<?php session_start(); 
require_once './WS/Login/wsfacturacion.php';
error_reporting(0);
             $pagina = $_GET["p"];
             if (!$pagina) {
                $inicio=0;
                $pagina=1;
             }
if (isset($_SESSION["RFC"])) {
    if (isset($_POST["fecha"])) {
      $fecha = $_POST["fecha"]; 
      $fechaF=$_POST["fechaF"];
    }else{
      $fecha = date("Y-m-d");
      $fechaF = date("Y-m-d");
    }

  $ClienteConsultarFacturas = "ClienteConsultarFacturas";
  $decode = $ClienteConsultarFacturas($fecha,$fechaF,$_SESSION["RFC"],$pagina);


}else{
  header("Location: index.php");
  die();
}

?>
<html>
<head>
	<title>Grupo DP</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/esfact.css">
   <script Language=Javascript SRC="js/facturascorreo.js"></script>

</head>
<body>

<?php include("menu.php");?>


<div class="container">
  <div class="row main">
    <div id="form" class="main-login main-center">
   
		<form class="input-append form-horizontal" action="cliente_facturas.php" method="POST" >
			<div class="row">
				<div class="col-sm-4 col-sm-offset-2">
					<div class="form-group">
						<label for="fecha">DE:</label>
						<div class="input-group">
						  <input type="date" name="fecha" class="form-control" value="<?php echo $fecha ?>">
						  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label for="fechaF">HASTA:</label>
						<div class="input-group">
						  <input type="date" name="fechaF" class="form-control" value="<?php echo $fechaF ?>">
						  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<br/>
					<button type="submit" class="btn btn-primary entrar" name="Buscar">Buscar <i class="fa fa-arrow-right"></i></button> 
				</div>
			</div>
			
   	</form>
      <?php
             //echo $fecha;
             //print_r($decode["last_page"]);
             if (!$pagina ) {
                $inicio=0;
                $pagina=1;
             }else{
              $inicio = ($pagina-1) * $decode["per_page"];
             }
            // $total_paginas= $decode['total'] / $decode["per_page"];
            if ($decode["last_page"] > 1) {
               if ($pagina != 1)
                  echo '<a class="btn btn-primary entrar" href="cliente_facturas.php?p='.($pagina-1).'"><i class="fa fa-arrow-left" aria-hidden="true"></i>
</a>';
                  for ($i=1;$i<=$decode["last_page"];$i++) {
                     if ($pagina == $i)
                        //si muestro el índice de la página actual, no coloco enlace
                        echo '<a href="#" class="btn btn-primary entrar">'.$pagina.'<a/>';
                     else
                        //si el índice no corresponde con la página mostrada actualmente,
                        //coloco el enlace para ir a esa página
                        echo '  <a class="btn btn-primary entrar" href="cliente_facturas.php?p='.$i.'">'.$i.'</a>  ';
                  }
                  if ($pagina != $decode["last_page"])
                     echo ' <a class="btn btn-primary entrar" href="cliente_facturas.php?p='.($pagina+1).'"><i class="fa fa-arrow-right" aria-hidden="true"></i>
</a>';
            }
             ?>

             <?php
              if ($decode['total'] > 0) { ?>
              <div class="table-responsive">       
                       <table class="table">
                         <thead>
                           <th>UUID</th>
                           <th>FECHA</th>
                           <th>RFC</th>
                           <th>Folio</th>
                           <th>Receptor</th>
                           <th>Monto</th>
                           <th>Tipo</th>
                           <th>PDF</th>
                           <th>XML</th>
                           <th>CORREO</th>
                         </thead>
                         <tbody>
                         <?php
                          foreach ($decode["data"] as $variable ) { ?>
                           <tr>
                             <td><?php echo $variable["uuid"]; ?> </td>
                             <td><?php echo $variable["created_at"]; ?> </td>
                             <td><?php echo $variable["receiver"]; ?></td>
                             <td><?php echo $variable["metadata"][0][1]; ?></td>
                             <td><?php echo $variable["metadata"][1][1]; ?></td>
                             <td><?php echo "$".number_format((float)$variable["metadata"][3][1],2); ?></td>
                             <td><?php echo $variable["metadata"][4][1]; ?></td>
                             <td><a href="http://factura.arafacturacion.webaccess.mx/api/v1/download/<?php echo $variable["uuid"] ?>?ext=pdf" class="btn btn-primary entrar botones"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar</a></td>
                             <td><a href="http://factura.arafacturacion.webaccess.mx/api/v1/download/<?php echo $variable["uuid"] ?>?ext=xml" class="btn btn-primary entrar botones"><i class="fa fa-file-code-o" aria-hidden="true"></i> Descargar</a></td>
                             <td><a href="#" OnClick="EnviarCorreo('<?php echo $variable["uuid"]; ?>','<?php echo $_SESSION["EMAIL"]; ?>');" class="btn btn-danger botones"><i class="fa fa-envelope" aria-hidden="true"></i>
 Enviar</a></td>
                           </tr>   
                          <?php } ?>

                         </tbody>
                       </table> 
                  </div>
              <?php } ?>
                    <?php

              // $total_paginas= $decode['total'] / $decode["per_page"];
                        if ($decode["last_page"] > 1) {
                           if ($pagina != 1)
                              echo '<a class="btn btn-primary entrar" href="cliente_facturas.php?p='.($pagina-1).'"><i class="fa fa-arrow-left" aria-hidden="true"></i>
            </a>';
                              for ($i=1;$i<=$decode["last_page"];$i++) {
                                 if ($pagina == $i)
                                    //si muestro el índice de la página actual, no coloco enlace
                                    echo '<a href="#" class="btn btn-primary entrar">'.$pagina.'<a/>';
                                 else
                                    //si el índice no corresponde con la página mostrada actualmente,
                                    //coloco el enlace para ir a esa página
                                    echo '  <a class="btn btn-primary entrar" href="cliente_facturas.php?p='.$i.'">'.$i.'</a>  ';
                              }
                              if ($pagina != $decode["last_page"])
                                 echo ' <a class="btn btn-primary entrar" href="cliente_facturas.php?p='.($pagina+1).'"><i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>';
                        }
                    ?>
              </div>
       </div>
</div>


<button type="button"  style="display:none;" id="modal" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

<div class="modal fade" id="myModal" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
               <center><p><img class="image-responsive" src='img/load.gif'></p></center>    
    </div>
        <button id="cerrarmodal" style="display:none;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>


<br><br>
<?php include("footer.php"); ?>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/bootstrap.js"></script> 

</body>
</html>