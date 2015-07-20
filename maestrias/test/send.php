<?		
$MailTo="allenzapien@um.edu.mx";
$email=$_POST['email'];
$contenido='
E-mail: '.utf8_decode($email).'
';
mail($MailTo, "$Subject interesado en el test de maestrías", $contenido, "From: $email");
header('Location: gracias.html');
?>