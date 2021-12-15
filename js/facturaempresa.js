$(document).ready(function() {
var Modificar=0;
deshabilitar();

function hola(){
  return true;
}


function deshabilitar() {
  Modificar=0;
  $("#IdCliente").attr("disabled", "disabled");
  $("#Nombre").attr("disabled", "disabled");
  $("#ApellidoP").attr("disabled", "disabled");
  $("#ApellidoM").attr("disabled", "disabled");
  $("#Calle").attr("disabled", "disabled");
  $("#NumeroEx").attr("disabled", "disabled");
  $("#Distrito").attr("disabled", "disabled");
  $("#CP").attr("disabled", "disabled");
  $("#Region").attr("disabled", "disabled");
  $("#Telefono").attr("disabled", "disabled");
  $("#Email").attr("disabled", "disabled");
  $("#EstadoCivil").attr("disabled", "disabled");
  $("#Sexo").attr("disabled", "disabled");
  $("#Ciudad").attr("disabled", "disabled");
  $("#NumeroIn").attr("disabled", "disabled");
    $("#FechaNacimiento").attr("disabled", "disabled");
}

function habilitar(){
  Modificar=1;
  $("#IdCliente").removeAttr("disabled");
  $("#Nombre").removeAttr("disabled");
  $("#ApellidoP").removeAttr("disabled");
  $("#ApellidoM").removeAttr("disabled");
  $("#Calle").removeAttr("disabled");
  $("#NumeroEx").removeAttr("disabled"); 
  $("#Distrito").removeAttr("disabled");
  $("#CP").removeAttr("disabled");
  $("#Region").removeAttr("disabled");
  $("#Telefono").removeAttr("disabled");
  $("#Email").removeAttr("disabled");
  $("#EstadoCivil").removeAttr("disabled");
  $("#Sexo").removeAttr("disabled"); 
  $("#Ciudad").removeAttr("disabled"); 
  $("#NumeroIn").removeAttr("disabled"); 
  $("#FechaNacimiento").removeAttr("disabled"); 
}

function formDefault(){
            $("#Nombre").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#ApellidoP").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#ApellidoM").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#NumeroEx").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Distrito").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#CP").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Region").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Telefono").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Email").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#EstadoCivil").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Sexo").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Ciudad").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#Ticket").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#MetodoPago").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#UsoDelCFDI").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#NumeroIn").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
            $("#FechaNacimiento").css({"border-style": "solid", "border-color": "gray","border-width":"1px"});
}

    /*$("#MetodoPago").on("change",function()
    {
      var optionSelected = $("option:selected", this);
      var valueSelected = this.value;
      alert(optionSelected);
      alert(valueSelected);
      if($("#MetodoPago").val()=="03" || $("#MetodoPago").val()=="04" || $("#MetodoPago").val()=="28"){
        $("#txtnreferencia").show();
        $("#ref").show();
      }else{
        $("#txtnreferencia").hide();
        $("#ref").hide();
        $("#ref").val("");
      }
    }); */


      $("#BtnSubmitTicket").click(function(){
        if($("#Ticket").val()==""){
            $("#Ticket").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Ticket";
            return;
        }
        
        if($("#MetodoPago").val()==""){
            $("#MetodoPago").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#MetodoPago";
            return;
        }

        if($("#UsoDelCFDI").val()==""){
            $("#UsoDelCFDI").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#UsoDelCFDI";
            return;
        }

        /*if($("#MetodoPago").val()=="03"||$("#MetodoPago").val()=="04"||$("#MetodoPago").val()=="28"){
          if ($("#ref").val()=="") {
             $("#ref").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
             window.location.href = "#ref";
             return;
          }
        }*/

        $.ajax({
            url: './WS/DPticket.php',
            data: { Ticket: $("#Ticket").val(), MetodoPago: $("#MetodoPago").val(), UsoDelCFDI: $("#UsoDelCFDI").val() },
            type: "POST",
             beforeSend: function () {
                 formDefault();
                 $("#modal").click();
                },
            success: function (data) {
              formDefault();
              $("#MostrarTicket").html(data);
              $("#cerrarmodal").click();

                   $("#GenerarFactura").click(function() { 
                                  $.ajax({
                                      url: './WS/DPticketPDFXML33.php',
                                      //data: {NumeroInt: $("#NumeroIn").val(), Referencia:$("#ref").val(),MetodoPago:$("#MetodoPago").val(), MetodoPagoTexto: $("#MetodoPago option:selected").html(), Ticket: $("#Ticket").val(),RFC: $("#RFC").val(), Nombre: $("#Nombre").val(), ApellidoP: $("#ApellidoP").val(), Calle: $("#Calle").val(), NumeroEx: $("#NumeroEx").val(), Distrito: $("#Distrito").val(), CP: $("#CP").val(), Pais: $("#Pais").val(), Region: $("#Region").val(), Telefono: $("#Telefono").val(), Email: $("#Email").val(), EstadoCivil: $("#EstadoCivil").val(), Sexo: $("#Sexo").val(), Ciudad: $("#Ciudad").val()},
                                      data: { NumeroInt: $("#NumeroIn").val(), Ticket: $("#Ticket").val(), MetodoPago: $("#MetodoPago").val(), UsoDelCFDI: $("#UsoDelCFDI").val(), RFC: $("#RFC").val(), Nombre: $("#Nombre").val(), ApellidoP: $("#ApellidoP").val(), ApellidoM: $("#ApellidoM").val(), Calle: $("#Calle").val(), NumeroEx: $("#NumeroEx").val(), Distrito: $("#Distrito").val(), CP: $("#CP").val(), Pais: $("#Pais").val(), Region: $("#Region").val(), Telefono: $("#Telefono").val(), Email: $("#Email").val(), EstadoCivil: $("#EstadoCivil").val(), Sexo: $("#Sexo").val(), Ciudad: $("#Ciudad").val()},
                                      type: "POST",
                                       beforeSend: function () {
                                           formDefault();
                                           $("#modal").click();
                                          },
                                      success: function (data) {
                                        formDefault();
                                        $("#MostrarTicket").html(data);
                                        $("#cerrarmodal").click();
                                                       $("#email").click(function() { 
                                                              $.ajax({
                                                                  url: './WS/DPPDFXMLEmail.php',
                                                                  data: { Nombre: $("#Nombre").val(), 
                                                                          ApellidoP: $("#ApellidoP").val(), 
                                                                          Email: $("#Email").val(), 
                                                                          namezip: $("#namezip").val(),
                                                                          urizip: $("#zipx").val() },
                                                                  type: "POST",
                                                                   beforeSend: function () {
                                                                       formDefault();
                                                                       $("#modal").click();
                                                                      },
                                                                  success: function (data) {
                                                                    formDefault();
                                                                    $("#respuesta").html(data);
                                                                    $("#cerrarmodal").click();
                                                                    window.location.href = "#respuesta";
                                                                  },
                                                                  error: function(data) {
                                                                    $("#cerrarmodal").click();
                                                                    alert("Error! Consulte a un Administrador");
                                                                    formDefault();
            
                                                                  }
                                                              });                    
                                               });
                                        window.location.href = "#MostrarTicket";
                                      },
                                      error: function(data) {
                                        $("#cerrarmodal").click();
                                        alert("Error! Consulte a un Administrador");
                                        formDefault();
                                        
                                      }
                                  });                    
                   });
             
              window.location.href = "#MostrarTicket";
            },
            error: function(data) {
              $("#cerrarmodal").click();
              alert("Error! Consulte a un Administrador");
              formDefault();
              
            }
        });     

    });

      $("#btnsubmit").click(function(){
      if (Modificar==0) {
          habilitar();
      }else{

        if($("#Nombre").val()==""){
            $("#Nombre").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Nombre";
            return;
        }

        if($("#NumeroEx").val()==""){
            $("#NumeroEx").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#NumeroEx";
            return;
        }
          if($("#Distrito").val()==""){
            $("#Distrito").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Distrito";
            return;
        }
        if($("#CP").val()==""){
            $("#CP").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#CP";
            return;
        }
        if($("#Region").val()==""){
            $("#Region").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Region";
            return;
        }
        if($("#Telefono").val()==""){
            $("#Telefono").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Telefono";
            return;
        }
        if($("#Email").val()==""){
            $("#Email").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Email";
            return;
        }
       if($("#Sexo").val()==""){
            $("#Sexo").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Sexo";
            return;
        }
        if($("#Ciudad").val()==""){
            $("#Ciudad").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#Ciudad";
            return;
        }
        if($("#FechaNacimiento").val()==""){
            $("#FechaNacimiento").css({"border-style": "solid", "border-color": "red","border-width":"1px"});
            window.location.href = "#FechaNacimiento";
            return;
        }
        $.ajax({
            url: './WS/DPmodificacionEmpresa.php',
            data: {NumeroIn: $("#NumeroIn").val(), FechaNacimiento: $("#FechaNacimiento").val(), RFC: $("#RFC").val(), IdCliente: $("#IdCliente").val(), Nombre: $("#Nombre").val(), ApellidoP: $("#ApellidoP").val(), ApellidoM: $("#ApellidoM").val(), Calle: $("#Calle").val(), NumeroEx: $("#NumeroEx").val(), Distrito: $("#Distrito").val(), CP: $("#CP").val(), Pais: $("#Pais").val(), Region: $("#Region").val(), Telefono: $("#Telefono").val(), Email: $("#Email").val(), EstadoCivil: $("#EstadoCivil").val(), Sexo: $("#Sexo").val(), Ciudad: $("#Ciudad").val()},
            type: "POST",
             beforeSend: function () {
                 formDefault();
                 $("#modal").click();
                 deshabilitar();

                },
            success: function (data) {
              formDefault();
              $("#Layout").html(data)
              $("#cerrarmodal").click();
              deshabilitar();
            },
            error: function(data) {
              alert("Error!");
              formDefault();
              $("#cerrarmodal").click();
              deshabilitar();
            }
        });     
      }

    });

 });     
