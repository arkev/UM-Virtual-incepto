<?php

//variables
$nombre=$_GET["nombre"];
$email=$_GET["email"];

//Variables
$to = "umvirtual@um.edu.mx";
$from = "Allen Zapien <allenzapien@um.edu.mx>";
$subject = "$nombre ha iniciado su proceso de admisión";

//Mensaje para UM Virtual
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
<tr>
     <td colspan='2'>ha iniciado su proceso de admisión</td>
</tr>
</table>
</body>
</html>
";

//Headers UM Virtual
$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type:text/html;charset=UTF-8";
$headers[] = "From: $from";
$headers[] = "Bcc: $from";
$headers[] = "Reply-To: $nombre <$email>";

//Enviar mail a UM Virtual
mail($to,$subject,$message,implode("\r\n", $headers));

//Redirigir a gracias.html
echo"<script>window.location='http://umvirtual.org/admision/'</script>;"
    
?>