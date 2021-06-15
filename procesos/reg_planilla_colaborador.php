<?php

require '../class/cl_planilla_colaborador.php';
require '../class/cl_detalle_planilla.php';
require '../class/cl_planilla.php';

$cl_general = new cl_planilla();
$cl_detalle = new cl_planilla_colaborador();
$cl_planilla = new cl_detalle_planilla();

$almuerzos = 0;
$cl_detalle->setPlanilla(filter_input(INPUT_POST, 'input_planilla'));
$cl_general->setCodigo(filter_input(INPUT_POST, 'input_planilla'));
$cl_detalle->setColaborador(filter_input(INPUT_POST, 'input_id_colaborador'));

$a_datos = $cl_general->ver_datos_planilla();
foreach ($a_datos as $value) {
    $cl_general->setAlimentacion($value['alimentacion']);
    $cl_general->setLocal($value['local']);
}

$inicio_lunes = filter_input(INPUT_POST, 'select_ingreso_1');
$salida_lunes = filter_input(INPUT_POST, 'select_salida_1');
$horas_lunes = $salida_lunes - $inicio_lunes;
if (filter_input(INPUT_POST, 'check_feriado_1') == 1) {
    $cl_detalle->setFeriado(filter_input(INPUT_POST, 'check_feriado_1'));
} else {
    $cl_detalle->setFeriado(0);
}

if ($horas_lunes > 0 || $cl_detalle->getFeriado() == 1) {
    $cl_detalle->setDia(1);
    $cl_detalle->setIngreso($inicio_lunes);
    $cl_detalle->setSalida($salida_lunes);
    $cl_detalle->i_empleado();
    if ($cl_detalle->getFeriado() == 1) {
        $horas_norm_lunes = 8;
        $horas_ext25_lunes = 0;
        $horas_ext100_lunes = $horas_lunes;
    } else {
        $almuerzos++;
        if ($horas_lunes < 9) {
            $horas_norm_lunes = $horas_lunes;
            $horas_ext25_lunes = 0;
            $horas_ext100_lunes = 0;
        } else {
            $horas_norm_lunes = 8;
            $horas_ext25_lunes = $horas_lunes - 9;
            $horas_ext100_lunes = 0;
        }
    }
}
$inicio_martes = filter_input(INPUT_POST, 'select_ingreso_2');
$salida_martes = filter_input(INPUT_POST, 'select_salida_2');
$horas_martes = $salida_martes - $inicio_martes;
if (filter_input(INPUT_POST, 'check_feriado_2') == 1) {
    $cl_detalle->setFeriado(filter_input(INPUT_POST, 'check_feriado_2'));
} else {
    $cl_detalle->setFeriado(0);
}

if ($horas_martes > 0 || $cl_detalle->getFeriado() == 1) {
    $cl_detalle->setDia(2);
    $cl_detalle->setIngreso($inicio_martes);
    $cl_detalle->setSalida($salida_martes);
    $cl_detalle->i_empleado();
    if ($cl_detalle->getFeriado() == 1) {
        $horas_norm_martes = 8;
        $horas_ext25_martes = 0;
        $horas_ext100_martes = $horas_martes;
    } else {
        $almuerzos++;
        if ($horas_martes < 9) {
            $horas_norm_martes = $horas_martes;
            $horas_ext25_martes = 0;
            $horas_ext100_martes = 0;
        } else {
            $horas_norm_martes = 8;
            $horas_ext25_martes = $horas_martes - 9;
            $horas_ext100_martes = 0;
        }
    }
}
$inicio_miercoles = filter_input(INPUT_POST, 'select_ingreso_3');
$salida_miercoles = filter_input(INPUT_POST, 'select_salida_3');
$horas_miercoles = $salida_miercoles - $inicio_miercoles;
if (filter_input(INPUT_POST, 'check_feriado_3') == 1) {
    $cl_detalle->setFeriado(filter_input(INPUT_POST, 'check_feriado_3'));
} else {
    $cl_detalle->setFeriado(0);
}

if ($horas_miercoles > 0 || $cl_detalle->getFeriado() == 1) {
    $cl_detalle->setDia(3);
    $cl_detalle->setIngreso($inicio_miercoles);
    $cl_detalle->setSalida($salida_miercoles);
    $cl_detalle->i_empleado();
    if ($cl_detalle->getFeriado() == 1) {
        $horas_norm_miercoles = 8;
        $horas_ext25_miercoles = 0;
        $horas_ext100_miercoles = $horas_miercoles;
    } else {
        $almuerzos++;
        if ($horas_miercoles < 9) {
            $horas_norm_miercoles = $horas_miercoles;
            $horas_ext25_miercoles = 0;
            $horas_ext100_miercoles = 0;
        } else {
            $horas_norm_miercoles = 8;
            $horas_ext25_miercoles = $horas_miercoles - 9;
            $horas_ext100_miercoles = 0;
        }
    }
}

$inicio_jueves = filter_input(INPUT_POST, 'select_ingreso_4');
$salida_jueves = filter_input(INPUT_POST, 'select_salida_4');
$horas_jueves = $salida_jueves - $inicio_jueves;
if (filter_input(INPUT_POST, 'check_feriado_4') == 1) {
    $cl_detalle->setFeriado(filter_input(INPUT_POST, 'check_feriado_4'));
} else {
    $cl_detalle->setFeriado(0);
}

$horas_ext100_domingo = 0;

if ($horas_jueves > 0 || $cl_detalle->getFeriado() == 1) {
    $cl_detalle->setDia(4);
    $cl_detalle->setIngreso($inicio_jueves);
    $cl_detalle->setSalida($salida_jueves);
    $cl_detalle->i_empleado();
    if ($cl_detalle->getFeriado() == 1) {
        $horas_norm_jueves = 8;
        $horas_ext25_jueves = 0;
        $horas_ext100_jueves = $horas_jueves;
    } else {
        $almuerzos++;
        if ($horas_jueves < 9) {
            $horas_norm_jueves = $horas_jueves;
            $horas_ext25_jueves = 0;
            $horas_ext100_jueves = 0;
        } else {
            $horas_norm_jueves = 8;
            $horas_ext25_jueves = $horas_jueves - 9;
            $horas_ext100_jueves = 0;
        }
    }
}

$inicio_viernes = filter_input(INPUT_POST, 'select_ingreso_5');
$salida_viernes = filter_input(INPUT_POST, 'select_salida_5');
$horas_viernes = $salida_viernes - $inicio_viernes;
if (filter_input(INPUT_POST, 'check_feriado_5') == 1) {
    $cl_detalle->setFeriado(filter_input(INPUT_POST, 'check_feriado_5'));
} else {
    $cl_detalle->setFeriado(0);
}

if ($horas_viernes > 0 || $cl_detalle->getFeriado() == 1) {
    $cl_detalle->setDia(5);
    $cl_detalle->setIngreso($inicio_viernes);
    $cl_detalle->setSalida($salida_viernes);
    $cl_detalle->i_empleado();
    if ($cl_detalle->getFeriado() == 1) {
        $horas_norm_viernes = 8;
        $horas_ext25_viernes = 0;
        $horas_ext100_viernes = $horas_viernes;
    } else {
        $almuerzos++;
        if ($horas_viernes < 9) {
            $horas_norm_viernes = $horas_viernes;
            $horas_ext25_viernes = 0;
            $horas_ext100_viernes = 0;
        } else {
            $horas_norm_viernes = 8;
            $horas_ext25_viernes = $horas_viernes - 9;
            $horas_ext100_viernes = 0;
        }
    }
}

$inicio_sabado = filter_input(INPUT_POST, 'select_ingreso_6');
$salida_sabado = filter_input(INPUT_POST, 'select_salida_6');
$horas_sabado = $salida_sabado - $inicio_sabado;
if (filter_input(INPUT_POST, 'check_feriado_6') == 1) {
    $cl_detalle->setFeriado(filter_input(INPUT_POST, 'check_feriado_6'));
} else {
    $cl_detalle->setFeriado(0);
}

if ($horas_sabado > 0 || $cl_detalle->getFeriado() == 1) {
    $cl_detalle->setDia(6);
    $cl_detalle->setIngreso($inicio_sabado);
    $cl_detalle->setSalida($salida_sabado);
    $cl_detalle->i_empleado();
    if ($cl_detalle->getFeriado() == 1) {
        $horas_norm_sabado = 8;
        $horas_ext25_sabado = 0;
        $horas_ext100_sabado = $horas_sabado;
    } else {
        $almuerzos++;
        if ($horas_sabado < 9) {
            $horas_norm_sabado = $horas_sabado;
            $horas_ext25_sabado = 0;
            $horas_ext100_sabado = 0;
        } else {
            $horas_norm_sabado = 8;
            $horas_ext25_sabado = $horas_sabado - 9;
            $horas_ext100_sabado = 0;
        }
    }
}

$inicio_domingo = filter_input(INPUT_POST, 'select_ingreso_7');
$salida_domingo = filter_input(INPUT_POST, 'select_salida_7');
$horas_domingo = $salida_domingo - $inicio_domingo;

if ($horas_domingo > 0) {
    $cl_detalle->setDia(7);
    $cl_detalle->setFeriado(0);
    $cl_detalle->setIngreso($inicio_domingo);
    $cl_detalle->setSalida($salida_domingo);
    $cl_detalle->i_empleado();
    $horas_ext100_domingo = $horas_domingo;
    if ($horas_domingo < 9) {
        $horas_ext100_domingo = $horas_domingo;
    } else {
        $almuerzos++;
        $horas_ext100_domingo = $horas_domingo - 1;
    }
}

$cl_planilla->setPlanilla(filter_input(INPUT_POST, 'input_planilla'));
$cl_planilla->setColaborador(filter_input(INPUT_POST, 'input_id_colaborador'));
$cl_planilla->setJornal(filter_input(INPUT_POST, 'input_jornal_colaborador'));
//$total_horas = $horas_jueves + $horas_viernes + $horas_sabado + $horas_lunes + $horas_martes + $horas_miercoles;

$h_normal = $horas_norm_jueves + $horas_norm_viernes + $horas_norm_sabado + $horas_norm_lunes + $horas_norm_martes + $horas_norm_miercoles;
$h_25 = $horas_ext25_jueves + $horas_ext25_viernes + $horas_ext25_sabado + $horas_ext25_lunes + $horas_ext25_martes + $horas_ext25_miercoles;
$h_100 = $horas_ext100_jueves + $horas_ext100_viernes + $horas_ext100_sabado + $horas_ext100_domingo + $horas_ext100_lunes + $horas_ext100_martes + $horas_ext100_miercoles;

if ($cl_general->getLocal() == 2) {
    if ($almuerzos > 3) {
        $almuerzos = $almuerzos + 1;
    }
}
$cl_planilla->setI_alimentacion($almuerzos * $cl_general->getAlimentacion());
$cl_planilla->setH_normal($h_normal);
$cl_planilla->setH_25($h_25);
$cl_planilla->setH_100($h_100);

if ($cl_planilla->i_detalle()) {
    header("Location: ../ver_detalle_planilla.php?codigo=" . $cl_planilla->getPlanilla());
}
