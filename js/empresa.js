$(document).ready(function() {
function formDefault(){
            $("#ex1").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Nombre").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#ApellidoP").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            //$("#ApellidoM").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Calle").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#NumeroEx").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Distrito").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#CP").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Region").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Telefono").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Email").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            //$("#EstadoCivil").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            //$("#Sexo").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Ciudad").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Ticket").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#NumeroIn").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#FechaNacimiento").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
}


      $("#btnsubmit").click(function(){
        
        if($("#ex1").val().trim()==""){
            $("#ex1").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#ex1";
            return;
        }
        if($("#Nombre").val().trim()==""){
            $("#Nombre").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Nombre";
            return;
        }

        /*if($("#ApellidoP").val().trim()==""){
            $("#ApellidoP").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#ApellidoP";
            return;
        }*/

        if($("#Calle").val().trim()==""){
            $("#Calle").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Calle";
            return;
        }
        if($("#NumeroEx").val().trim()==""){
            $("#NumeroEx").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#NumeroEx";
            return;
        }

          if($("#Distrito").val().trim()==""){
            $("#Distrito").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Distrito";
            return;
        }
        if($("#CP").val().trim()==""){
            $("#CP").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#CP";
            return;
        }
        if($("#Region").val().trim()==""){
            $("#Region").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Region";
            return;
        }
        if($("#Telefono").val().trim()==""){
            $("#Telefono").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Telefono";
            return;
        }
        if($("#Email").val().trim()==""){
            $("#Email").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Email";
            return;
        }
        if($("#Ciudad").val().trim()==""){
            $("#Ciudad").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Ciudad";
            return;
        }
        if($("#FechaNacimiento").val().trim()==""){
            $("#FechaNacimiento").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#FechaNacimiento";
            return;
        }
        $.ajax({
            url: './WS/DPaltaempresa.php',
            data: {NumeroIn: $("#NumeroIn").val(), FechaNacimiento: $("#FechaNacimiento").val(), RFC: $("#ex1").val(), Nombre: $("#Nombre").val(), ApellidoP: $("#ApellidoP").val(), /*ApellidoM: $("#ApellidoM").val(),*/ Calle: $("#Calle").val(), NumeroEx: $("#NumeroEx").val(), Distrito: $("#Distrito").val(), CP: $("#CP").val(), Pais: $("#Pais").val(), Region: $("#Region").val(), Telefono: $("#Telefono").val(), Email: $("#Email").val(), EstadoCivil: $("#EstadoCivil").val(),  Ciudad: $("#Ciudad").val()},
            type: "POST",
             beforeSend: function () {
                 formDefault();
                 $("#modal").click();

                },
            success: function (data) {
              formDefault();
              if (data=='1') {
                //location.href="index.php?v=1";
                var pagina = 'factura.php?RFC=';
                var rfcPag = $("#ex1").val();
                var redirecciona = pagina.concat(rfcPag);
                location.href= redirecciona;
              }else{
                $("#Layout").html(data);
              }
              $("#cerrarmodal").click();
            },
            error: function(data) {
              alert("Error!");
              formDefault();
              $("#cerrarmodal").click();
            }
        });     
      

    });

 });     
