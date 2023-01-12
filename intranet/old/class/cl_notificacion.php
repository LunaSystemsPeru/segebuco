<?php

$_SESSION['cumpleanos'] = array();
$_SESSION['notificaciones'] = array();

require_once 'cl_empleado.php';
require_once 'cl_entrega_epp.php';

class cl_notificacion {

    private $titulo;
    private $mensaje;
    private $sub_mensaje;
    private $codigo;

    function __construct() {
        $this->cumpleanos();
        $this->cambios_epp();
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function getSub_mensaje() {
        return $this->sub_mensaje;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    function setSub_mensaje($sub_mensaje) {
        $this->sub_mensaje = $sub_mensaje;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function add_cumpleaños() {
        $fila = array();
        $fila['titulo'] = $this->titulo;
        $fila['descripcion'] = $this->mensaje;
        $fila['mensaje'] = $this->sub_mensaje;
        array_push($_SESSION['cumpleanos'], $fila);
    }

    function add_notificaciones() {
        $fila = array();
        $fila['titulo'] = $this->titulo;
        $fila['descripcion'] = $this->mensaje;
        $fila['mensaje'] = $this->sub_mensaje;
        $fila['codigo'] = $this->codigo;
        array_push($_SESSION['notificaciones'], $fila);
    }

    function cumpleanos() {
        $cl_empleado = new cl_empleado();
        $a_cumpleanos = $cl_empleado->v_cumpleanos_mes();
        foreach ($a_cumpleanos as $value) {
            $this->titulo = "Cumpleaños el dia " . $value['dia'];
            $this->mensaje = $value['nombres'];
            $this->sub_mensaje = $value['anio'] . ' - ' . $value['edad'] . ' años';
            $this->add_cumpleaños();
        }
    }

    function cambios_epp() {
        $cl_cambios = new cl_entrega_epp();
        $a_cambios = $cl_cambios->cambios_detallados();
        foreach ($a_cambios as $value) {
            $this->titulo = "Cambio de EPP";
            $this->mensaje = $value['ape_pat'] . " " . $value['ape_mat'] . " " . $value['nombres'] . "<br>" . $value['epp'];
            $this->sub_mensaje = 'Fecha Cambio.: ' . $value['fecha_cambio'];
            $this->codigo = $value['id'];
            $this->add_notificaciones();
        }
    }

}
