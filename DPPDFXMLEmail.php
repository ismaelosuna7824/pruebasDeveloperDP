<?php


$xmluri = $_POST['Xml'];
$namexml=$_POST['namexml'];
$namepdf=$_POST['namepdf'];
$pdfuri = $_POST['Pdf'];
$nombre = $_POST['Nombre'];
$apellido = $_POST['ApellidoP'];
$emai = $_POST['Email'];
#$form = "jesus@araconsultoria.com.mx";
//$emai = "francisco.rojo@dportenis.com.mx";
$Reply="ing.aocegueda@gmail.com";

   ini_set("include_path", __DIR__."../PHPMailer/");
   require '../PHPMailer/PHPMailerAutoload.php';
   $mail = new PHPMailer();      
   $mail->setLanguage('es',  __DIR__."../PHPMailer/language/");
   $mail->SMTPDebug = SMTP::DEBUG_SERVER;
   $mail->SMTPDebug = 0;
   $mail->IsSMTP();
   //$mail->SMTPAuth = true;
   $mail->SMTPAuth = false;
   //$mail->Host = "mail.grupodp.com.mx"; 
   $mail->Host = "aspmx.l.google.com"; 
   $mail->Username = 'facturacion.electron@dportenis.com.mx'; 
   $mail->Password = 'F4ctur4as2017';
   $mail->From = "facturacion.electronica@dportenis.com.mx";
   $mail->Port = 25;
   //$mail->SMTPSecure = "tls";
   $mail->SMTPSecure = false;
   $mail->AddAddress($emai,$nombre);
   $mail->Subject = "Dp Facturacion";
   $body  = file_get_contents("email.html");
   $mail->Body = $body;
   $mail->IsHTML(true);
   $mail->AddAttachment($xmluri, $namexml);
   $mail->AddAttachment($pdfuri, $namepdf); 
      if(!$mail->Send()) {
      echo "Error al enviar el Correo: ". $mail->ErrorInfo;
      } else {
         echo '
    <div class="alert alert-success alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Correcto!</strong> Correo Enviado Exitosamente  
    </div>
    ';
      
      }
/*try {
     // require '../PHPMailer/PHPMailerAutoload.php';
      include("../PHPMailer/class.phpmailer.php");
      //include("../PHPMailer/class.smtp.php");
      $mail = new PHPMailer();
      $mail -> IsSMTP();
      $mail->Host="mail.grupodp.com.mx";
      //$mail->Username='notificacionesdo';
     // $mail->Password='CONTRASEÑA';
     // $mail->From="notificacionesdo@dportenis.com.mx";
      $mail ->SMTPAuth = true;
      $mail ->Port =25;
      $mail->SMTPsecure="tls";
      $mail->Username = 'facturacion.electronica';
      $mail->Password = 'F4ctur4as2017';
      $mail->From = "facturacion.electronica@dportenis.com.mx";
      //$mail->FromName = "DP Facturacion";
      $mail->AddAddress($emai,$nombre); 
      $mail->Subject = "Dp Facturacion";
      //$mail->SMTPsecure="tls";
      //$mail->AddEmbeddedImage('../img/logopdf.png','imagen');
      $body  = file_get_contents("email.html");
      $mail->Body = $body;
      $mail->IsHTML(true);
      $mail->AddAttachment($xmluri, $namexml);
      $mail->AddAttachment($pdfuri, $namepdf); 
      //$mail->Send();

      if(!$mail->Send()) {
      echo "Error al enviar el Correo: ". $mail->ErrorInfo;
      } else {
      echo "Correo enviado!!";
      }


} catch (Exception $e) {

   echo "Error!!!".$e;
   error_log($e, 3, 'error_dp.log');   

}*/


