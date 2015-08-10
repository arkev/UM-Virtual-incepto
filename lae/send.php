<?php
//Datos
$nombre=$_POST["nombre"];
$email=$_POST["email"];
$to = "umvirtual@um.edu.mx";
$from = "Allen Zapien <allenzapien@um.edu.mx>";
$subject = "$nombre está solicitando una beca en la Licenciatura en Administración 
de Empresas";

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
</tr>
<tr>
<td>$email</td>
<td>$nombre</td>
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

//Headers
$headers2   = array();
$headers2[] = "MIME-Version: 1.0";
$headers2[] = "Content-type:text/html;charset=UTF-8";
$headers2[] = "From: $from";
$headers2[] = "Bcc: $from";
$headers2[] = "Reply-To: $nombre <$email>";

mail("elifelet@um.edu.mx","segundo correo","otro mensaje",implode("\r\n", $headers2));
echo"<script>window.location='gracias.html'</script>;"
?>
