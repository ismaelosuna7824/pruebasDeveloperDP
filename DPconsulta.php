<?php
require_once 'DPWS/SapZmfFunction.php';

 $SapZbapiSelectclientebyrfc="SapZbapiSelectclientebyrfc";
 $decoded=$SapZbapiSelectclientebyrfc($POSRFC);

if (!empty($decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"])) {

  $IDC=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["KUNNR"];
  $RFC=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["RFC"];
  $Nombre=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["NAME1"];
  $ApellidoP=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["NAME2"];
  $ApellidoM=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["NAME3"];
  $Calle=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["STREET"];
  $NumeroEx=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["NUMEXT"];
  if (isset($decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["NUMINT"])) 
    $NumeroIn=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["NUMINT"];
  else
    $NumeroIn="";
  $Ciudad=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["ORT01"];
  $Distrito=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["DISTRI"];
  $CP=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["PSTLZ"];
  $Pais=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["PAIS"];
  $Region=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["REGIO"];
  $Telefono=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["TELF1"];
  $Email=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["EMAIL"];
  $EstadoCivil=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["ECIVIL"];
  $Sexo=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["SEXO"];
  
  if (isset($decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["FENAC"])) 
    $FENAC=$decoded["SapZbapiSelectclientebyrfc"]["SapDatoscliente"][0]["FENAC"];
  else
    $FENAC="";

}else{
	header('Location: cliente.php?RFC='.$POSRFC);
}








?>