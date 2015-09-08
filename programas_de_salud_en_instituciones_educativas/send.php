<?php
//Datos
$nombre=$_POST["nombre"];
$email=$_POST["email"];
$escuela=$_POST["escuela"];
$tel=$_POST["tel"];
$to = "allenzapien@um.edu.mx";
$from = "Allen Zapien <allenzapien@um.edu.mx>";
$subject = "$nombre está solictando entrar al programa de salud en instituciones educativas";

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
<th>Nombre:</th>
<th>Institución en la que trabaja:</th>
<th>Teléfono de contácto:</th>
</tr>
<tr>
<td>$email</td>
<td>$nombre</td>
<td>$escuela</td>
<td>$tel</td>
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
$headers[] = "Bcc: $from";
$headers[] = "Reply-To: $nombre <$email>";


//Funciones
mail($to,$subject,$message,implode("\r\n", $headers));
echo"<script>window.location='gracias.html'</script>;"
?>