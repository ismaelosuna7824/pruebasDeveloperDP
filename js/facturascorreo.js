   function EnviarCorreo(uuid,correo) 
   { 
      //alert('Ha hecho click sobre el boton: ' + uuid +', de valor:'+correo); 
      $.ajax({
                url: './WS/Login/enviar_correo_facturas.php',
                data: {email: correo, uuid: uuid},
                type: "POST",
                 beforeSend: function () {
                     //formDefault();
                     $("#modal").click();
                     //deshabilitar();
                     // console.log(boton.value);

                    },
                success: function (data) {
                 // formDefault();
                 $("#Layout").html(data);
                 $("#cerrarmodal").click();
                 // deshabilitar();
                        //               console.log(boton.value);

                },
                error: function(data) {
                  alert("Error!");
                 // formDefault();
                  $("#cerrarmodal").click();
                  //deshabilitar();
                  //console.log(boton.value);

                }
            }) 
      //return true; 
   } 

