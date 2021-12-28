<?php

function SapZmfCommx1033FactPortal($Ticket,$documento,$UUID,$Comprobante,$TimbradoFecha)
{
   $service_url = 'http://189.202.187.23:7082/pos/autofacturacion'; // Produccion
	 //$service_url = 'http://189.202.187.24:7082/pos/autofacturacion'; //DEV
    $curl = curl_init($service_url);
    $curl_post_data ='
    { 
       "SapZmfCommx1033FactPortal":{ 
          "Parametros":{ 
             "E_RETURN_ERROR":"",
             "SapTFacturaPortal":{ 
                "BSTNK":"'.$Ticket.'",
                "VBELN":"'.$documento.'",
                "UUID":"'.$UUID.'",
                "TIPOCOMPROBANTE":"'.$Comprobante.'",
                "FECHATIMBRADO":"'.$TimbradoFecha[0].'",
                "HORATIMBRADO":"'.$TimbradoFecha[1].'"
             }
          }
       }
    }';
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
    curl_setopt($curl, CURLOPT_TIMEOUT, 1800000000);

    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        //   echo ":D500";
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    return json_decode($curl_response,true);
}	

function  SapZmfCommx1030Generaxmlportal($Ticket,$T_RETORNO)
{

    $service_url = 'http://189.202.187.24:7082/pos/autofacturacion';
   //$service_url = 'http://189.202.187.23:7082/pos/autofacturacion';
    $curl = curl_init($service_url);
    $curl_post_data = '
    {"SapZmfCommx1030Generaxmlportal":{ "Parametros":{"I_REFERENCIA":"'.$Ticket.'","I_TIPO_RETORNO":"'.$T_RETORNO.'"}}}';
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
    curl_setopt($curl, CURLOPT_TIMEOUT, 1800000000);

    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        //   echo ":D500";
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    return json_decode($curl_response,true);
}


function SapZbapiSelectclientebyrfc($RFC){

        //$service_url = 'http://189.202.187.24:7082/pos/clientes'; //Dev no funciona esta apagado
        $service_url = 'http://189.202.187.23:7082/pos/clientes'; //Produccion

        $curl = curl_init($service_url);
        $curl_post_data = '{  
           "SapZbapiSelectclientebyrfc":{  
              "Parametros":{  
                
                 "I_RFC":"'.$RFC.'"
              }
           }
        }';

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);

        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl); 

        return json_decode($curl_response,true);
}

function SapZbapiSelectEmpresaientebyrfc($RFC){

        $service_url = 'http://189.202.187.24:7082/pos/clientes';
        //$service_url = 'http://189.202.187.23:7082/pos/clientes';

        $curl = curl_init($service_url);
        $curl_post_data = '{  
           "SapZbapiSelectclientebyrfc":{  
              "Parametros":{          
                 "I_RFC":"'.$RFC.'"
              }
           }
        }';

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl); 

        return json_decode($curl_response,true);
}

function SapZbapisd26Altaclient($AKONT,$Sexo,$ANTLF,$BZIRK,$KTOKD,$EstadoCivil,$Email,$Pais,$I_SORTL,$KTGRD,$KZAZU,$Nombre,$ApellidoP,$ApellidoM,$NumeroEx,$NUMINT,$RFC,$LPRIO,$Telefono,$TIPO_CLIENTE,$Ciudad,$Distrito,$PRFRE,$CP,$Region,$SPART,$Calle,$VKORG,$VERSG,$VSBED,$VTWEG,$FENAC){

            //$service_url = 'http://189.202.187.24:7082/pos/autofacturacion';
            $service_url = 'http://189.202.187.23:7082/pos/autofacturacion';
            $curl = curl_init($service_url);
            $curl_post_data = '
            {
               "SapZbapisd26Altaclient":{ 
                  "Parametros":{ 
                     "AKONT":"'.$AKONT.'",
                     "ANRED":"'.$Sexo.'",
                     "ANTLF":"'.$ANTLF.'",
                     "BZIRK":"'.$BZIRK.'",
                     "KTOKD":"'.$KTOKD.'",
                     "EDOCIV":"'.$EstadoCivil.'",
                     "EMAIL":"'.$Email.'",
                     "LAND1":"'.$Pais.'",
                     "I_SORTL":"'.$I_SORTL.'",
                     "KTGRD":"'.$KTGRD.'",
                     "KZAZU":"'.$KZAZU.'",
                     "NAME1":"'.$Nombre.'",
                     "NAME2":"'.$ApellidoP.'",
                     "NAME3":"'.$ApellidoM.'",
                     "NUMEXT":"'.$NumeroEx.'",
                     "NUMINT":"'.$NUMINT.'",
                     "STCD1":"'.$RFC.'",
                     "LPRIO":"'.$LPRIO.'", 
                     "TELF1":"'.$Telefono.'",
                     "TIPO_CLIENTE":"'.$TIPO_CLIENTE.'",
                     "ORT01":"'.$Ciudad.'",
                     "ORT02":"'.$Distrito.'",
                     "PRFRE":"'.$PRFRE.'",
                     "PSTLZ":"'.$CP.'",
                     "REGIO":"'.$Region.'",
                     "SPART":"'.$SPART.'",
                     "STRAS":"'.$Calle.'",
                     "VKORG":"'.$VKORG.'",
                     "VERSG":"'.$VERSG.'",
                     "VSBED":"'.$VSBED.'",
                     "VTWEG":"'.$VTWEG.'",
                     "TELX1":"'.date("Ymd", strtotime($FENAC)).'"
                  }
               }
            }
            ';
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);

            return json_decode($curl_response,true);

}

function SapZbapisd26AltaEmpresa($AKONT,$Sexo,$ANTLF,$BZIRK,$KTOKD,$EstadoCivil,$Email,$Pais,$I_SORTL,$KTGRD,$KZAZU,$Nombre,$ApellidoP,$NumeroEx,$NUMINT,$RFC,$LPRIO,$Telefono,$TIPO_CLIENTE,$Ciudad,$Distrito,$PRFRE,$CP,$Region,$SPART,$Calle,$VKORG,$VERSG,$VSBED,$VTWEG,$FENAC){

            $service_url = 'http://189.202.187.24:7082/pos/autofacturacion';
            //$service_url = 'http://189.202.187.23:7082/pos/autofacturacion';
            $curl = curl_init($service_url);
            $curl_post_data = '
            {
               "SapZbapisd26Altaclient":{ 
                  "Parametros":{ 
                     "AKONT":"'.$AKONT.'",
                     "ANRED":"'.$Sexo.'",
                     "ANTLF":"'.$ANTLF.'",
                     "BZIRK":"'.$BZIRK.'",
                     "KTOKD":"'.$KTOKD.'",
                     "EDOCIV":"'.$EstadoCivil.'",
                     "EMAIL":"'.$Email.'",
                     "LAND1":"'.$Pais.'",
                     "I_SORTL":"'.$I_SORTL.'",
                     "KTGRD":"'.$KTGRD.'",
                     "KZAZU":"'.$KZAZU.'",
                     "NAME1":"'.$Nombre.'",
                     "NAME2":"'.$ApellidoP.'",
                     "NUMEXT":"'.$NumeroEx.'",
                     "NUMINT":"'.$NUMINT.'",
                     "STCD1":"'.$RFC.'",
                     "LPRIO":"'.$LPRIO.'", 
                     "TELF1":"'.$Telefono.'",
                     "TIPO_CLIENTE":"'.$TIPO_CLIENTE.'",
                     "ORT01":"'.$Ciudad.'",
                     "ORT02":"'.$Distrito.'",
                     "PRFRE":"'.$PRFRE.'",
                     "PSTLZ":"'.$CP.'",
                     "REGIO":"'.$Region.'",
                     "SPART":"'.$SPART.'",
                     "STRAS":"'.$Calle.'",
                     "VKORG":"'.$VKORG.'",
                     "VERSG":"'.$VERSG.'",
                     "VSBED":"'.$VSBED.'",
                     "VTWEG":"'.$VTWEG.'",
                     "TELX1":"'.date("Ymd", strtotime($FENAC)).'" 
                  }
               }
            }
            ';
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);

            return json_decode($curl_response,true);

}




function SapZbapisd26Modifclient($AKONT,$Sexo,$ANTLF,$BZIRK,$EstadoCivil,$Email,$Pais,$IDC,$KTGRD,$KZAZU,$Nombre,$ApellidoP,$ApellidoM,$NumeroEx,$NUMINT,$RFC,$LPRIO,$Telefono,$TIPO_CLIENTE,$Ciudad,$Distrito,$PRFRE,$CP,$Region,$SPART,$Calle,$VKORG,$VERSG,$VSBED,$VTWEG,$FENAC){

         // $service_url = 'http://189.202.187.24:7082/pos/autofacturacion';
         $service_url = 'http://189.202.187.23:7082/pos/autofacturacion';
            $curl = curl_init($service_url);
            $curl_post_data =         '
            {
               "SapZbapisd26Modifclient":{ 
                  "Parametros":{ 
                     "AKONT":"'.$AKONT.'",
                     "ANRED":"'.$Sexo.'",
                     "ANTLF":"'.$ANTLF.'",
                     "BZIRK":"'.$BZIRK.'",
                     "EDOCIV":"'.$EstadoCivil.'",
                     "EMAIL":"'.$Email.'",
                     "LAND1":"'.$Pais.'",
                     "KUNNR":"'.$IDC.'",
                     "KTGRD":"'.$KTGRD.'",
                     "KZAZU":"'.$KZAZU.'",
                     "NAME1":"'.$Nombre.'",
                     "NAME2":"'.$ApellidoP.'",     
                     "NAME3":"'.$ApellidoM.'",
                     "NUMEXT":"'.$NumeroEx.'",
                     "NUMINT":"'.$NUMINT.'",
                     "STCD1":"'.$RFC.'",
                     "LPRIO":"'.$LPRIO.'", 
                     "TELF1":"'.$Telefono.'",
                     "TIPO_CLIENTE":"'.$TIPO_CLIENTE.'",
                     "ORT01":"'.$Ciudad.'",
                     "ORT02":"'.$Distrito.'",
                     "PRFRE":"'.$PRFRE.'",
                     "PSTLZ":"'.$CP.'",
                     "REGIO":"'.$Region.'",
                     "SPART":"'.$SPART.'",
                     "STRAS":"'.$Calle.'",
                     "VKORG":"'.$VKORG.'",
                     "VERSG":"'.$VERSG.'",
                     "VSBED":"'.$VSBED.'",
                     "VTWEG":"'.$VTWEG.'",
                     "TELX1":"'.date("Ymd", strtotime($FENAC)).'"
                  }
               }
            }';

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);

            return json_decode($curl_response,true);
}

function SapZbapisd26ModifEmpresa($AKONT,$Sexo,$ANTLF,$BZIRK,$EstadoCivil,$Email,$Pais,$IDC,$KTGRD,$KZAZU,$Nombre,$ApellidoP,$NumeroEx,$NUMINT,$RFC,$LPRIO,$Telefono,$TIPO_CLIENTE,$Ciudad,$Distrito,$PRFRE,$CP,$Region,$SPART,$Calle,$VKORG,$VERSG,$VSBED,$VTWEG,$FENAC){

          $service_url = 'http://189.202.187.24:7082/pos/autofacturacion';
          //$service_url = 'http://189.202.187.23:7082/pos/autofacturacion';
            $curl = curl_init($service_url);
            $curl_post_data =         '
            {
               "SapZbapisd26Modifclient":{ 
                  "Parametros":{ 
                     "AKONT":"'.$AKONT.'",
                     "ANRED":"'.$Sexo.'",
                     "ANTLF":"'.$ANTLF.'",
                     "BZIRK":"'.$BZIRK.'",
                     "EDOCIV":"'.$EstadoCivil.'",
                     "EMAIL":"'.$Email.'",
                     "LAND1":"'.$Pais.'",
                     "KUNNR":"'.$IDC.'",
                     "KTGRD":"'.$KTGRD.'",
                     "KZAZU":"'.$KZAZU.'",
                     "NAME1":"'.$Nombre.'",
                     "NAME2":"'.$ApellidoP.'",
                     "NUMEXT":"'.$NumeroEx.'",
                     "NUMINT":"'.$NUMINT.'",
                     "STCD1":"'.$RFC.'",
                     "LPRIO":"'.$LPRIO.'", 
                     "TELF1":"'.$Telefono.'",
                     "TIPO_CLIENTE":"'.$TIPO_CLIENTE.'",
                     "ORT01":"'.$Ciudad.'",
                     "ORT02":"'.$Distrito.'",
                     "PRFRE":"'.$PRFRE.'",
                     "PSTLZ":"'.$CP.'",
                     "REGIO":"'.$Region.'",
                     "SPART":"'.$SPART.'",
                     "STRAS":"'.$Calle.'",
                     "VKORG":"'.$VKORG.'",
                     "VERSG":"'.$VERSG.'",
                     "VSBED":"'.$VSBED.'",
                     "VTWEG":"'.$VTWEG.'",
                     "TELX1":"'.date("Ymd", strtotime($FENAC)).'"
                  }
               }
            }';
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);

            return json_decode($curl_response,true);
}