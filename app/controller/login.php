<?php
require '../../tools/Zebra_Session.php';
require '../../models/Usuario.php';

$Usuario = new Usuario();
$Conectar = Conectar::getInstancia();

$password = filter_input(INPUT_POST, 'input-password');
$Usuario->setUsername(filter_input(INPUT_POST, 'input-usuario'));

$Usuario->validarUsername();

if ($Usuario->getId()) {
    //usuario existe
    //verisifcar si esta activo
    $Usuario->obtenerDatos();
    if ($Usuario->getEstado() == 1) {
        //verificar contraseña :
        if ($Usuario->getPassword() == $password) {
            $link = $Conectar->getLink();
            try {
                $zebra = new Zebra_Session($link, 'sEcUr1tY_c0dE');
                $activesession = $zebra->get_active_sessions();
            } catch (Exception $e) {
                echo $e;
            }

            $_SESSION['usuarioid'] = $Usuario->getId();
            $Usuario->actualizarLogeo();
            header("Location: ../contents/app-tareas.php");
        } else {
            //contraseña incorrecta
            header("Location: ../contents/app-login.php?error=4");
        }
    } else {
        //usuario bloqueado
        header("Location: ../contents/app-login.php?error=2");
    }
} else {
    //usuario no existe
    header("Location: ../contents/app-login.php?error=1");
}