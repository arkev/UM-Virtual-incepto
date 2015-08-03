<?php
//Datos
$email=$_POST['email'];
$to = "allenzapien@um.edu.mx";
$from = "$email>";
$subject = "correo de una persona que quiere el test de maestrias";

//Mensaje
$message = "
<html>
<head>
<title>$subject</title>
</head>
<body>
<table>
<tr>
<th>E-mail:</th>
</tr>
<tr>
<td>$email</td>
</tr>
</table>
</body>
</html>
";

//Headers
$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type:text/html;charset=UTF-8";
$headers[] = "From: $from";


//Funciones
mail($to,$subject,$message,implode("\r\n", $headers));
echo"<script>window.location='gracias.html'</script>;"
?>