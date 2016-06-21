<?php

//Variables
$to = "umvirtual@um.edu.mx";
$from = "Allen Zapien <allenzapien@um.edu.mx>";
$subject = "$nombre está solicitando una beca en la Licenciatura en Administración 
de Empresas";
$subjectUsr = "$nombre te hago llegar la información básica de beca en la Licenciatura en Administración de Empresas";
$toUsr = $email;
$anio = 2015;

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
</table>
</body>
</html>
";

//Mensaje para el usuario
$messageUsr ="
<html>
<head>
<title>$subjectUsr</title>
</head>
<body>
<table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                            <tbody><tr>
                                <td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                    <!-- BEGIN PREHEADER // -->
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' id='templatePreheader' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;'>
                                        <tbody><tr>
                                        	<td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='600' class='templateContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                    <tbody><tr>
                                                        <td valign='top' class='preheaderContainer' style='padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>                                            
                                        </tr>
                                    </tbody></table>
                                    <!-- // END PREHEADER -->
                                </td>
                            </tr>
                            <tr>
                                <td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                    <!-- BEGIN HEADER // -->
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' id='templateHeader' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;'>
                                        <tbody><tr>
                                            <td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='600' class='templateContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                    <tbody><tr>
                                                        <td valign='top' class='headerContainer' style='padding-top: 10px;padding-bottom: 10px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnTextBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td valign='top' class='mcnTextBlockInner' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                
                <table align='left' border='0' cellpadding='0' cellspacing='0' width='600' class='mcnTextContentContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                    <tbody><tr>
                        
                        <td valign='top' class='mcnTextContent' style='padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;'>
                        
                            <img align='none' alt='Universidad de Montemorelos | UM Virtual' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/5d228493-93e4-4026-ae19-ae3e0d891042.jpg' style='width: 100%;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;height: auto !important;' width='100%'>
                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END HEADER -->
                                </td>
                            </tr>
                            <tr>
                                <td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                    <!-- BEGIN BODY // -->
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' id='templateBody' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;'>
                                        <tbody><tr>
                                            <td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='600' class='templateContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                    <tbody><tr>
                                                        <td valign='top' class='bodyContainer' style='padding-top: 10px;padding-bottom: 10px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnTextBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td valign='top' class='mcnTextBlockInner' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                
                <table align='left' border='0' cellpadding='0' cellspacing='0' width='600' class='mcnTextContentContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                    <tbody><tr>
                        
                        <td valign='top' class='mcnTextContent' style='padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;'>
                        
                            <div style='background:#e7ddd0; color:#333333;padding:0 0 14px 0'><img align='none' height='55' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/af5768b2-46ab-4111-878a-fe876c1a31db.jpg' style='width: 600px;height: 55px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='600'>
<p style='padding: 10px 54px;margin: 1em 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;'>Hola $nombre que gusto saber del interés que tienes en nuestro programa, seguro que deseas tener información más precisa ¿verdad? Para que te animes y tomes la decisión de estudiar con nosotros mira el video y conoce la experiencia de un alumno UM Virtual.</p>
<a href='http://umvirtual.org/la-experiencia-del-conocimiento-en-linea/' target='_blank' style='word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #6DC6DD;font-weight: normal;text-decoration: underline;'><img align='center' alt='La experienci UM' height='200' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/b18f663b-39a0-4eda-b0da-30edb0e58285.jpg' style='width: 361px;height: 200px;margin: 0 auto 18px;display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='361'></a></div>

                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnTextBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td valign='top' class='mcnTextBlockInner' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                
                <table align='left' border='0' cellpadding='0' cellspacing='0' width='600' class='mcnTextContentContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                    <tbody><tr>
                        
                        <td valign='top' class='mcnTextContent' style='padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;'>
                        
                            <img align='none' alt='check' height='86' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/311fe43d-8ff0-4f15-a91b-123842960b18.jpg' style='width: 600px;height: 86px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='600'>
<p style='color: #333333;margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;'>Sabemos que para tí es importante conocer la trascendencia y la calidad de nuestra institución, bueno, puedo decirte que la UM tiene 72 años de experiencia educativa, es una Institución internacional, ya que recibe alumnos de más de 30 países.<br>
<br>
Todos sus programas tienen reconocimiento de validez oficial, la Universidad tiene la acreditación de calidad de Instituciones de Educación Superior (FIMPES). Los organismos que acreditan su prestigio, trayectoria y calidad son:</p>

<table style='color: #333333;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
	<tbody>
		<tr>
			<td style='text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img align='none' alt='FIMPES' height='56' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/34225cf4-539f-4941-93ed-ba7a9b58221e.jpg' style='width: 51px;height: 56px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='51'></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Federación de Instituciones Mexicanas Particulares de Educación Superior, A.C</td>
		</tr>
		<tr>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
		</tr>
		<tr>
			<td style='text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img align='none' alt='ANUIES' height='57' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/cdd7f62d-6212-4517-897c-671776042e4c.jpg' style='width: 41px;height: 57px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='41'></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Asociación Nacional de Universidades e Instituciones de Educación Superior en México</td>
		</tr>
		<tr>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
		</tr>
		<tr>
			<td style='text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img align='none' alt='AAA' height='64' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/5e3f5341-9672-4e70-895c-19357157813a.jpg' style='width: 55px;height: 64px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='55'></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Asociación Acreditadora Adventista</td>
		</tr>
		<tr>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
		</tr>
		<tr>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img align='none' alt='SEP' height='53' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/e64b4fc8-87f2-465a-8fb3-ed88f98a28c7.jpg' style='width: 94px;height: 53px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='94'></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>&nbsp;</td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Secretaria de Educación Pública</td>
		</tr>
	</tbody>
</table>

                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnTextBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td valign='top' class='mcnTextBlockInner' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                
                <table align='left' border='0' cellpadding='0' cellspacing='0' width='600' class='mcnTextContentContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                    <tbody><tr>
                        
                        <td valign='top' class='mcnTextContent' style='padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;'>
                        
                            <img align='none' alt='Time' height='70' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/45888245-12cd-4092-a0e5-dd54a8e5e71f.jpg' style='width: 600px;height: 70px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='600'>
<h2 style='color: #1d164e!important;margin: 0;padding: 0;display: block;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: -.75px;text-align: left;'>No esperes más y ¡aprovecha los beneficios de la beca promocional!</h2>

<p style='color: #333333;text-align: center;margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;font-family: Helvetica;font-size: 15px;line-height: 150%;'>Licenciatura en Administración de Empresas - 16 créditos</p>

<table style='margin: 0 auto 14px;background: #635285;color: #d0cbda;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
	<tbody>
		<tr style='background:#d0cbda;color:#635285;'>
			<th style='padding:5px;border: 1px solid #635285;'>Precio Regular</th>
			<th style='padding:5px;border: 1px solid #635285;'>Precio con Beca</th>
		</tr>
		<tr>
			<td style='padding: 5px;border: 1px solid #d0cbda;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>$8,992.00 x mes</td>
			<td style='padding: 5px;border: 1px solid #d0cbda;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>$4,496.00 x mes</td>
		</tr>
	</tbody>
</table>

                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnButtonBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody class='mcnButtonBlockOuter'>
        <tr>
            <td style='padding-top: 0;padding-right: 18px;padding-bottom: 18px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;' valign='top' align='center' class='mcnButtonBlockInner'>
                <table border='0' cellpadding='0' cellspacing='0' class='mcnButtonContentContainer' style='border-collapse: separate !important;border: 2px solid #635285;border-radius: 5px;background-color: #635285;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                    <tbody>
                        <tr>
                            <td align='center' valign='middle' class='mcnButtonContent' style='font-family: Arial;font-size: 16px;padding: 16px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                <a class='mcnButton ' title='Comenzar inscripción' href='http://localhost:5757/lae/comenzar.php?nombre=$nombre&email=$email' target='_blank' style='font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Comenzar inscripción</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                            <tr>
                                <td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                    <!-- BEGIN FOOTER // -->
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' id='templateFooter' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #F2F2F2;border-top: 0;border-bottom: 0;'>
                                        <tbody><tr>
                                            <td align='center' valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='600' class='templateContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                                                    <tbody><tr>
                                                        <td valign='top' class='footerContainer' style='padding-top: 10px;padding-bottom: 10px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnFollowBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody class='mcnFollowBlockOuter'>
        <tr>
            <td align='center' valign='top' style='padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;' class='mcnFollowBlockInner'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnFollowContentContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody><tr>
        <td align='center' style='padding-left: 9px;padding-right: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnFollowContent' style='border: 1px solid #EEEEEE;background-color: #FAFAFA;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                <tbody><tr>
                    <td align='center' valign='top' style='padding-top: 9px;padding-right: 9px;padding-left: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
						<table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
							<tbody><tr>
								<td valign='top' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                        
			                            
			                                <table align='left' border='0' cellpadding='0' cellspacing='0' class='mcnFollowStacked' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                     
			                                    <tbody><tr>
			                                        <td align='center' valign='top' class='mcnFollowIconContent' style='padding-right: 10px;padding-bottom: 5px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                            <a href='https://www.facebook.com/umvirtual' target='_blank' style='word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img src='https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-96.png' alt='Facebook' class='mcnFollowBlockIcon' width='48' style='width: 48px;max-width: 48px;display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;'></a>
			                                        </td>
			                                    </tr>
			                                    
			                                    
			                                    <tr>
			                                        <td align='center' valign='top' class='mcnFollowTextContent' style='padding-right: 10px;padding-bottom: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                            <a href='https://www.facebook.com/umvirtual' target='_blank' style='color: #606060;font-family: Arial;font-size: 11px;font-weight: normal;line-height: 100%;text-align: center;text-decoration: none;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Facebook</a>
			                                        </td>
			                                    </tr>
			                                    
			                                </tbody></table>
			                            
			                            
								<!--[if gte mso 6]>
								</td>
						    	<td align='left' valign='top'>
								<![endif]-->
			                        
			                            
			                                <table align='left' border='0' cellpadding='0' cellspacing='0' class='mcnFollowStacked' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                     
			                                    <tbody><tr>
			                                        <td align='center' valign='top' class='mcnFollowIconContent' style='padding-right: 10px;padding-bottom: 5px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                            <a href='https://twitter.com/UMVirtual' target='_blank' style='word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img src='https://cdn-images.mailchimp.com/icons/social-block-v2/color-twitter-96.png' alt='Twitter' class='mcnFollowBlockIcon' width='48' style='width: 48px;max-width: 48px;display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;'></a>
			                                        </td>
			                                    </tr>
			                                    
			                                    
			                                    <tr>
			                                        <td align='center' valign='top' class='mcnFollowTextContent' style='padding-right: 10px;padding-bottom: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                            <a href='https://twitter.com/UMVirtual' target='_blank' style='color: #606060;font-family: Arial;font-size: 11px;font-weight: normal;line-height: 100%;text-align: center;text-decoration: none;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Twitter</a>
			                                        </td>
			                                    </tr>
			                                    
			                                </tbody></table>
			                            
			                            
								<!--[if gte mso 6]>
								</td>
						    	<td align='left' valign='top'>
								<![endif]-->
			                        
			                            
			                                <table align='left' border='0' cellpadding='0' cellspacing='0' class='mcnFollowStacked' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                     
			                                    <tbody><tr>
			                                        <td align='center' valign='top' class='mcnFollowIconContent' style='padding-right: 0;padding-bottom: 5px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                            <a href='https://www.youtube.com/channel/UCjs9VlOxEO3CmLapwYereoA' target='_blank' style='word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img src='https://cdn-images.mailchimp.com/icons/social-block-v2/color-youtube-96.png' alt='YouTube' class='mcnFollowBlockIcon' width='48' style='width: 48px;max-width: 48px;display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;'></a>
			                                        </td>
			                                    </tr>
			                                    
			                                    
			                                    <tr>
			                                        <td align='center' valign='top' class='mcnFollowTextContent' style='padding-right: 0;padding-bottom: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
			                                            <a href='https://www.youtube.com/channel/UCjs9VlOxEO3CmLapwYereoA' target='_blank' style='color: #606060;font-family: Arial;font-size: 11px;font-weight: normal;line-height: 100%;text-align: center;text-decoration: none;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>YouTube</a>
			                                        </td>
			                                    </tr>
			                                    
			                                </tbody></table>
			                            
			                            
								<!--[if gte mso 6]>
								</td>
						    	<td align='left' valign='top'>
								<![endif]-->
			                        
								</td>
							</tr>
						</tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnTextBlock' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td valign='top' class='mcnTextBlockInner' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                
                <table align='left' border='0' cellpadding='0' cellspacing='0' width='600' class='mcnTextContentContainer' style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
                    <tbody><tr>
                        
                        <td valign='top' class='mcnTextContent' style='padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;'>
                        
                            <em>Copyright © $anio Universidad de Montemorelos, Todos los derechos reservados.</em><br>
<br>

También puedes contactarte directamente con nosotros:<br>
<table style='border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>
	<tbody>
		<tr>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img align='none' alt='Home' height='21' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/c0b73531-e245-42c4-8d38-a3b970ec6451.png' style='width: 22px;height: 21px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='22'></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><strong>Visítanos</strong></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>Av. Libertad No. 1300 Poniente, Zaragoza, 67530 Montemorelos, Nuevo León, México</td>
		</tr>
		<tr>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img align='none' alt='Tel' height='21' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/1ce0da6d-3765-4435-bcc2-95a3986c3146.png' style='width: 21px;height: 21px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='21'></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><strong>Llama</strong></td>
			<td style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>(826) 263 2810 - (826) 263 0900 ext. 1251 y 1255</td>
		</tr>
		<tr>
			<td class='tg-031e' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><img align='none' alt='mail' height='19' src='https://gallery.mailchimp.com/458128645c72adf41ccbd28cd/images/fad65684-66a0-4a8d-af9a-e7d49c901cfd.png' style='width: 18px;height: 19px;margin: 0px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;' width='18'></td>
			<td class='tg-031e' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><strong>Escríbenos</strong></td>
			<td class='tg-031e' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'>umvirtual@um.edu.mx</td>
		</tr>
	</tbody>
</table>
<br>
                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END FOOTER -->
                                </td>
                            </tr>
                        </tbody></table>
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

//Headers Usuario
$headersUsr   = array();
$headersUsr[] = "MIME-Version: 1.0";
$headersUsr[] = "Content-type:text/html;charset=UTF-8";
$headersUsr[] = "From: $to";
$headersUsr[] = "Reply-To: UM Virtual <umvirtual@um.edu.mx>";

//Enviar mail al usuario
mail($toUsr,$subjectUsr,$messageUsr,implode("\r\n", $headersUsr));

//Redirigir a gracias.html
echo"<script>window.location='gracias.html'</script>;"
    
?>