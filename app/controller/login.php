<?php
require '../../tools/Zebra_Session.php';
require '../../models/Usuario.php';
require '../../models/Banco.php';

$Usuario = new Usuario();
$Banco  = new Banco();
$Conectar = Conectar::getInstancia();

$password = filter_input(INPUT_POST, 'input-password');
$Usuario->setUsuario(filter_input(INPUT_POST, 'input-usuario'));

$Usuario->verificarUsuario();

if ($Usuario->getId() > 0) {
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

            $Banco->setUsuarioid($Usuario->getId());
            $Banco->obtenerBancoUsuario();

            $_SESSION['usuarioid'] = $Usuario->getId();
            $_SESSION['bancoid'] = $Banco->getId();
//            $Usuario->actualizarLogeo();
            header("Location: ../contents/app-prestamos.php");
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