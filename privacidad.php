<?php session_start(); ?>
<html>
<head>
	<title></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
   <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="css/esfact.css">
</head>
<body>
<script> 
function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 
} 
function verificar_campos(e){

}

</script> 
<?php include("menu.php"); ?>

<div class="container">
  <div class="row main">
              <div id="form" class="main-login main-center">
                   <div class="infocliente col-lg-6">
                  <font face="Calibri Light" color="white" size="20">              
                    AVISO DE PRIVACIDAD
                  </font>
                  </div> 
                  <div class="col-lg-12">
                    
                    
                  </div>

              </div>
       </div>
</div>

<br><br>
<?php include("footer.php"); ?>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/bootstrap.js"></script> 

</body>
</html>