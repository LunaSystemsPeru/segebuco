<?php
include 'class/cl_notificacion.php';
require_once 'class/cl_almacen.php';
require_once 'class/cl_empleado.php';

$cl_ualmacen = new cl_almacen();
$cl_uempleado = new cl_empleado();
$cl_notificacion = new cl_notificacion();

$cl_ualmacen->setCodigo($_SESSION["almacen"]);
$cl_ualmacen->datos_almacen();

$cl_uempleado->setCodigo($_SESSION["empleado"]);
$cl_uempleado->obtener_datos();

$a_cumpleanos = $_SESSION['cumpleanos'];
$a_notificacion = $_SESSION['notificaciones'];
?>
<style>
    .scrollable-menu {
    height: auto;
    max-height: 500px;
    overflow-x: hidden;
}
</style>
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <a href="index.php" class="navbar-brand"><span class="navbar-logo"></span> SEGEBUCO SAC</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                    <i class="fa fa-bell-o"></i>
                    <span class="label"><?php echo count($a_cumpleanos) ?></span>
                </a>
                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Cumpleaños (<?php echo count($a_cumpleanos) ?>)</li>
                    <?php
                    foreach ($a_cumpleanos as $value) {
                        ?>
                        <li class="media">
                            <a href="javascript:;">
                                <div class="media-left"><i class="fa fa-birthday-cake media-object bg-red"></i></div>
                                <div class="media-body">
                                    <h6 class="media-heading"><?php echo $value['titulo'] ?></h6>
                                    <p><?php echo $value['descripcion'] ?></p>
                                    <div class="text-muted f-s-11"><?php echo $value['mensaje'] ?></div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                    <i class="fa fa-bell-o"></i>
                    <span class="label"><?php echo count($a_notificacion) ?></span>
                </a>
                <ul class="dropdown-menu scrollable-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Notificaciones (<?php echo count($a_notificacion) ?>)</li>
                    <?php
                    foreach ($a_notificacion as $value) {
                        ?>
                        <li class="media">
                            <a href="ver_entrega_epp.php?codigo=<?php echo $value['codigo'] ?>">
                                <div class="media-left"><i class="fa fa-bullhorn media-object bg-green"></i></div>
                                <div class="media-body">
                                    <h6 class="media-heading"><?php echo $value['titulo'] ?></h6>
                                    <p><?php echo $value['descripcion'] ?></p>
                                    <div class="text-muted f-s-11"><?php echo $value['mensaje'] ?></div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="assets/img/user-13.jpg" alt="" /> 
                    <span class="hidden-xs"><?php echo $cl_uempleado->getNombres() . ' ' . $cl_uempleado->getPaterno() . ' ' . $cl_uempleado->getMaterno() ?></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="javascript:;">Almacen: </a></li>
                    <li><a href="javascript:;"><?php echo $cl_ualmacen->getNombre() ?></a></li>
                    <li class="divider"></li>
                    <li><a href="ver_perfil.php">Editar Perfil</a></li>
                    <li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Mensajes</a></li>
                    <li><a href="javascript:;">Calendario</a></li>
                    <li class="divider"></li>
                    <li><a href="procesos/logout.php">Cerrar Sesion</a></li>
                </ul>
            </li>
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end container-fluid -->
</div>