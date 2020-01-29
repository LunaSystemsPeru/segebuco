<?php

session_start();

function TildesHtml($cadena) {
    return str_replace(array("á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ"), array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;",
        "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&Ntilde;"), $cadena);
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

$message = nl2br(TildesHtml(filter_input(INPUT_POST, 'input_mensaje')));
$subject = filter_input(INPUT_POST, 'input_asunto');

$email_to = filter_input(INPUT_POST, 'input_correo');
$from = 'info@lunasystemsperu.com';

$separator = md5(time());

$eol = PHP_EOL;
$archivo = filter_input(INPUT_POST, 'input_archivo');
$ccliente = filter_input(INPUT_POST, 'input_ccliente');
$csucursal = filter_input(INPUT_POST, 'input_ccsucursal');
$filename = "../upload/" . $ccliente . "/" . $csucursal . "/cotizacion/" . $archivo;
//echo "../upload/".$ccliente."/".$csucursal."/cotizacion/" . $archivo;

$pdfdoc = file_get_contents($filename);
$attachment = chunk_split(base64_encode($pdfdoc));

$email_from = 'info@lunasystemsperu.com';
$headers = "From: \"Area de Ventas - SEGEBUCO \"<" . $email_from . ">" . $eol;

$headers .= "MIME-Version: 1.0" . $eol;
$headers .= "Reply-To: clarrivierec@gmail.com" . $eol;
$headers .= "Bcc: clarrivierec@gmail.com" . $eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";

$body = "--" . $separator . $eol;

$body .= "Content-Type: text/html; charset=\"utf-8\"" . $eol;
$body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
$body .= $message . $eol;

// adjunto
$body .= "--" . $separator . $eol;
$body .= "Content-Type: application/octet-stream; name=\"" . $archivo . "\"" . $eol;
$body .= "Content-Transfer-Encoding: base64" . $eol;
$body .= "Content-Disposition: attachment" . $eol . $eol;
$body .= $attachment . $eol;
$body .= "--" . $separator . "--";

$error_ocurred = mail($email_to, $subject, $body, $headers);
if (!$error_ocurred) {
    echo "<center>Ocurrio un problema al enviar su información, intente mas tarde.<br/>";
    echo "Si el problema persiste contacte a un administrador.</center>";
} else {
    echo "<center>Su informacion ha sido enviada correctamente a la direccion de email especificada.<br/>(sientase libre de cerrar esta ventana)</center>";
    ?>
    <script>
        window.location.href = "../ver_cotizaciones.php";
    </script>
    <?php

}