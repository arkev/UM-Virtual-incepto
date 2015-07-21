<?php
//Datos
$nombre=$_POST['nombre'];
$email=$_POST['email'];
$to = "allenzapien@um.edu.mx";
$subject = "$nombre está solicitando una beca en la Maestría en Finansas";

//Mensaje
$message = "
<html>
<head>
<title>$subject</title>
</head>
<body>
<table>
<tr>
<th>Nombre:/th>
<th>E-mail:</th>
</tr>
<tr>
<td>$nombre</td>
<td>$email</td>
</tr>
</table>
</body>
</html>
";

//Headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: $email' . "\r\n";

//Funciones
mail($to,$subject,$message,$headers);
header('Location: gracias.html');
exit;
?>