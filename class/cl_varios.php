<?php

class cl_varios {

    function _primer_dia_mes() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
    }

    function fecha_mysql_web($source) {
        $date = new DateTime($source);
        return $date->format('d/m/Y');
    }
    
    function fecha_cotizacion($source) {
        $date = new DateTime($source);
        return $date->format('Y-md');
    }

    function anio_de_fecha($source) {
        $date = new DateTime($source);
        return $date->format('Y');
    }

    function mes_de_fecha($source) {
        $date = new DateTime($source);
        return $date->format('m');
    }

    function fecha_web_mysql($source) {
        $to_format = 'Y-m-d';
        $from_format = 'd/m/Y';
        $date_aux = date_create_from_format($from_format, $source);
        return date_format($date_aux, $to_format);
    }

    function fecha_mysql_larga_web($source) {
        $to_format = 'd/m/Y h:i A';
        $from_format = 'Y-m-d H:i:s';
        $date_aux = date_create_from_format($from_format, $source);
        return date_format($date_aux, $to_format);
    }

    function zerofill($valor, $longitud) {
        $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
        return $res;
    }

    function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++)
            $key .= $pattern[mt_rand(0, $max)];
        return $key;
    }

}
