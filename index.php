<?php session_start() ?>
<html>
<head>
	<title>Grupo DP</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/ess.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
  <?php include("menu.php"); ?>
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <h1 class="text-center">FACTURACIÓN</h1>
        <hr>
        <div id="form" class="main-login main-center">
          <font face="Roboto" size="4">
          <p class="text-center">INGRESA TU RFC</p></font>
          <form class="input-append" action="factura.php" method="POST" >
            <center>
              <div class="input-group col-lg-12">
                <input type="text" id="RFC" name="RFC" class="form-control" style="text-transform:uppercase"  placeholder="XXXXXXXXXXXXXX">
              </div>
            </br>
              <input type="image" type="submit" src="img/siguiente.png" width=180px margin-top=25px/>
            </center>
            <?php if (!strtoupper(isset($_SESSION["RFC"]))){?>
            <font face="Roboto" size="2" > 
              
                
                    
                
                <!-- <div class="col-sm-6 ml-2">
                  <a class="btn btn-default btn-xs btn-block pull-left linkregistro font-xs" href="cliente.php">
                    <strong> REGISTRO PERSONA FÍSICA</strong>
                  </a>
                </div>
                <div class="col-sm-6 mr-2">              
                  <a class="btn btn-default btn-xs btn-block pull-right linkregistro font-xs" href="empresa.php">
                    <strong>REGISTRO EMPRESA</strong>
                  </a>
                </div> !-->
              
            <?php } ?>
            </font>           
            <br>
            <center>
              <br/>
               
              <?php 
                if (isset($_GET["v"])) {
                  $desicion=$_GET["v"];
                  if ($desicion==0) {?>
                  <div class="alert alert-danger alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>ERROR!</strong> No se han agregado tus datos Correctamente.
                  </div>
                  <?php }else if($desicion==1){ ?>
                  <div class="alert alert-success alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Tu registro ha sido exitoso, agrega el folio del ticket y genera tu factura.  
                  </div>
                  <?php }else if($desicion==3){?>
                  <div class="alert alert-danger alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>ERROR!</strong> El RFC ya ha sido registrado. 
                  </div>
                  <?php
                  }
              } ?>
            </center>
          <form>
        </div>
        <hr>
      </div>
    </div>    
  </div>
  <?php include("footer.php"); ?>
  <div class="modal fade" id="myModal" tabsitio="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">AVISO DE PRIVACIDAD</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <center>
            <!-- <iframe width="100%" src="img/AVISO_DE_PRIVACIDAD.pdf"></iframe> !-->
            <div>
              <object data="img/AVISO_DE_PRIVACIDAD.pdf" type="application/pdf" width="100%" height="80%">
                  alt : <a href="img/AVISO_DE_PRIVACIDAD.pdf">Aviso Privacidad</a>
              </object>
          </div>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="js/jquery.js"></script> 
  <script type="text/javascript" src="js/bootstrap.js"></script> 
  </body>
</html>