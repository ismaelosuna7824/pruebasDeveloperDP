$(document).ready(function() {

      $("#Sexo").on("click", function(){
        if (this.value==="P"||this.value==="E") {
          $("#ApellidoP").show();
          $("#ApellidoM").show();
          $("#apep").show();
          $("#apem").show();
        }else{
          $("#ApellidoP").hide();
          $("#ApellidoM").hide();
          $("#apep").hide();
          $("#apem").hide();
        }

      });


 });     
