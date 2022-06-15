<?php
session_start();

function TildesHtml($cadena) 
{ 
	return str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
		array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
			"&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $cadena);     
}
/*
$denombre="Ventas Conmetal";
$deemail="ventas@conmetal.pe";
$sfrom="ventas@conmetal.pe"; //cuenta que envia
$sBCC="conmetal2@yahoo.es"; //me envio una copia oculta
$sdestinatario="proyectos@conmetal.pe"; //cuenta destino
$ssubject=filter_input(INPUT_POST, 'input_asunto'); //subject
$shtml=nl2br(TildesHtml(filter_input(INPUT_POST, 'input_mensaje'))) . "</p>"; 
$encabezados = "MIME-Version: 1.0\n";
$encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
$encabezados .= "From: $denombre <$deemail>\n";
$encabezados .= "X-Sender: <$sfrom>\n";
$encabezados .= "BCC: <$sBCC>\n"; //aqui fijo el BCC
$encabezados .= "X-Mailer: PHP\n";
$encabezados .= "X-Priority: 1\n"; // fijo prioridad
$encabezados .= "Return-Path: <$sfrom>\n";

mail($sdestinatario,$ssubject,$shtml,$encabezados);
*/

$body = file_get_contents("http://www.conmetal.pe/erp/resumen.php"); 
$subject = 'TEST - RESUMEN SEMANAL - SEGEBUCO SAC';

$email_to = 'ventas@conmetal.pe';
$from = 'ventas@conmetal.pe';
    
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= 'From: Robot Sistema <ventas@conmetal.pe>';

$error_ocurred = mail($email_to, $subject, $body, $cabeceras);

if(!$error_ocurred){
	echo "<center>Ocurrio un problema al enviar su información, intente mas tarde.<br/>";
	echo "Si el problema persiste contacte a un administrador.</center>";
}else{
	echo "<center>Su informacion ha sido enviada correctamente a la direccion de email especificada.<br/>(sientase libre de cerrar esta ventana)</center>";
}