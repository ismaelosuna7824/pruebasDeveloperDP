<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   $zipuri = $_POST['urizip'];
   $nombre = $_POST['Nombre'];
   $apellido = $_POST['ApellidoP'];
   $email = $_POST['Email'];
   echo $email;
   echo " " . $apellido;
   $namezip=$_POST['namezip'];
   //echo $zipuri;
   //$emai = "francisco.rojo@dportenis.com.mx";
   $Reply="ing.aocegueda@gmail.com";
   use PHPMailer\PHPMailer\PHPMailer;
   require 'PHPMailer/Exception.php';
   require 'PHPMailer/PHPMailer.php';
   require 'PHPMailer/SMTP.php';

   $mail = new PHPMailer(true);
   $mail->SMTPDebug = 0;
   //$mail->SMTPDebug = 1;
   //$mail->SMTPDebug = 2;
   $mail->SMTPAuth = true;
   $mail->SMTPSecure = "tls";
   //$mail->SMTPSecure = "ssl";
   $mail->Port = 587;
   //$mail->Port = 465;
   $mail->Host = "smtp.gmail.com";
   //$mail->Username = 'facturacion.electron@dportenis.com.mx';
   $mail->Username = 'facturacion.electronica@dportenis.com.mx';
   $mail->Password = 'F4ctur4as2017';


   $mail->IsHTML(true);
   //$mail->From = "facturacion.electronica@dportenis.com.mx";
   //$mail->AddAddress($emai,$nombre);
   $mail->AddAddress($email);
   //$mail->AddAddress('ing.aocegueda@gmail.com');
   $mail->setFrom("facturacion.electronica@dportenis.com.mx", "Facturas Grupo Dp");
   $mail->Subject = "Grupo Dp Facturacion";


   $mail->CharSet = 'UTF-8';
   $mail->IsSMTP();     

   /*$mail->SMTPOptions = array(
      'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
      )
   );*/   
   
   $body  = file_get_contents("email.html");
   $mail->Body = $body;   
   //$mail->AddAttachment($zipuri, $namezip);
   
   $ruta = explode("|", $zipuri);
   $nombres = explode("|", $namezip);

   $x = 0;
   $xRuta = array();
   $y = 0;
   $yNombre = array();

   foreach($ruta as $element)
   {
     $xRuta[$x] = $element;
     $x++;
   }

   $x=0;
   foreach($nombres as $element)
   {
     $yNombre[$x] = $element;
     $x++;
   }

   $arrlength = count($xRuta);

   for($x = 0; $x < $arrlength; $x++) 
   {
      if(!empty($xRuta[$x]))
      {
         $NRuta = $xRuta[$x];
         $NNombre = $yNombre[$x];
      
         $mail->AddAttachment(
         $NRuta,
         $NNombre,
         'base64',
         'mime/type');
      }
   }

   if(!$mail->Send()) {
   echo "Error al enviar el Correo: ". $mail->ErrorInfo;
   } 
   else {
      echo '
         <div class="alert alert-success alert-dismissable fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Correcto!</strong> Correo Enviado Exitosamente  
         </div>';
   }