<?php
require '../../tools/Zebra_Session.php';
require_once '../../models/Conectar.php';
$conectar = Conectar::getInstancia();
$link = $conectar->getLink();
try {
    $zebra = new Zebra_Session($link, 'sEcUr1tY_c0dE');
    if (isset($_SESSION["usuarioid"])) {
        $zebra->stop();
        header("location:../contents/app-login.php");
    }
} catch (Exception $e) {
    echo $e;
}
