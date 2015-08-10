<?php
//
$nombre=$_POST["nombre"];
$email=$_POST["email"];

//validación
if ($nombre=="" || $email=="") {
    echo "Los campos son obligatorios";
}
elseif ($nombre=="" && $email!="") {
    echo "El campo nombre es obligatorio";
}
elseif ($nombre!="" && $email=="") {
    echo "El campo email es obligatorio";
}
else {
    echo "Tu nombre es $nombre y tu correo es $email";
}

?>