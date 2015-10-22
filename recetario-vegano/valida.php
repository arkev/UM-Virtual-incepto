<?php

//variables
$nombre=$_POST["nombre"];
$email=$_POST["email"];
$errors = array(); // declaramos un array para almacenar los errores

function valida_email($mail){   
  if(eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $mail))   
  return true;   
    else  
  return false;
}

function valida_nombre($nombre){   
  if($nombre!="")   
  return true;   
    else  
  return false;
}

if(valida_nombre($nombre) and valida_email($email))
{ 
include("send.php");
}elseif (valida_nombre($nombre) xor valida_email($email)) {
    echo "los campos no son validos";
}
else { 
echo "El campo nombre y email NO son validos"; 
}
    

?>