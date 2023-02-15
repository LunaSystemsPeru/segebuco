<?php
//verificar sesion
//si no hya session enviar a login
//si hay sesion enviar a main,php


require '../fixed/cargarSession.php';
header("Location: main.php");

?>

