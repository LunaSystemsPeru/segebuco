<?php

include 'cl_conectar.php';

class cl_planilla {

    private $codigo;
    private $anio;
    private $semana;
    private $cliente;
    private $sucursal;
    private $inicio;
    private $final;
    private $usuario;
    private $estado;
    private $ccosto;
    private $alimentacion;
    private $local;
    private $monto;

    function __construct() {
        
    }

    function getLocal() {
        return $this->local;
    }

    function setLocal($local) {
        $this->local = $local;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function getAnio() {
        return $this->anio;
    }

    function getSemana() {
        return $this->semana;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getSucursal() {
        return $this->sucursal;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFinal() {
        return $this->final;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getEstado() {
        return $this->estado;
    }

    function getCcosto() {
        return $this->ccosto;
    }
    function getMonto() {
        return $this->monto;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

        function setAnio($anio) {
        $this->anio = $anio;
    }

    function setSemana($semana) {
        $this->semana = $semana;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setSucursal($sucursal) {
        $this->sucursal = $sucursal;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFinal($final) {
        $this->final = $final;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCcosto($ccosto) {
        $this->ccosto = $ccosto;
    }

    function getAlimentacion() {
        return $this->alimentacion;
    }

    function setAlimentacion($alimentacion) {
        $this->alimentacion = $alimentacion;
    }

    function i_planilla() {
        $grabado = false;
        global $conn;
        $query = "insert into planilla values ('" . $this->codigo . "', '" . $this->anio . "', '" . $this->semana . "', '" . $this->cliente . "', '" . $this->sucursal . "', "
                . "'" . $this->inicio . "', '" . $this->final . "', '" . $this->usuario . "',  '" . $this->alimentacion . "',  '" . $this->local . "', '0','0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in planilla: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_planillas($codigo) {
        global $conn;
        $query = "select p.codigo, p.anio, p.semana, e.razon_social, e.nombre_comercial, sc.nombre as sucursal, p.cliente as id_cliente, p.sucursal as id_sucursal, p.usuario, p.fecha_inicio, p.fecha_fin, p.estado, "
                . "ifnull (sum(dp.horas_normal / 8 * dp.jornal + if(dp.horas_normal / 8 = 6, dp.jornal, dp.jornal / 6 * dp.horas_normal / 8) + (dp.jornal / 8 * 1.25 * dp.horas_25) + (dp.jornal / 8 * 2 * dp.horas_100) + "
                . "dp.i_alimentacion + dp.i_gastos - dp.d_adelanto - dp.d_otros), 0) as planilla "
                . "from planilla as p "
                . "left join detalle_planilla as dp on dp.planilla = p.codigo "
                . "inner join clientes as c on c.id = p.cliente "
                . "left join colaborador as co on co.id = dp.colaborador "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = p.cliente and sc.id = p.sucursal "
                . "where concat (anio, lpad(semana, 3, 0)) = '" . $codigo . "' "
                . "group by p.codigo";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_semanas() {
        global $conn;
        $query = "select concat (anio, lpad(semana, 3, 0)) as semana "
                . "from planilla "
                . "group by anio, semana "
                . "order by anio desc, semana desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_semanas_planilla() {
        global $conn;
        $query = "select concat (anio, lpad(semana, 3, 0)) as semana "
                . "from planilla "
                . "where estado = 0 "
                . "group by anio, semana "
                . "order by anio desc, semana desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_clientes_semana($codigo) {
        global $conn;
        $query = "select distinct p.cliente, e.nombre_comercial, e.razon_social "
                . "from planilla as p "
                . "inner join clientes as c on c.id = p.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "where concat (anio, lpad(semana, 3, 0)) = '" . $codigo . "' and p.estado = '0' "
                . "order by e.razon_social asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_sucursal_semana($codigo) {
        global $conn;
        $query = "select p.codigo, sc.nombre as nsucursal, p.sucursal, p.estado "
                . "from planilla as p "
                . "inner join sucursal_cliente as sc on sc.cliente = p.cliente and sc.id = p.sucursal "
                . "where concat (anio, lpad(semana, 3, 0)) = '" . $codigo . "' and p.cliente = '" . $this->cliente . "' "
                . "order by sc.nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    /*
      $query = "select p.codigo, p.anio, p.semana, e.nombre_comercial, sc.nombre as sucursal, p.cliente as id_cliente, p.sucursal as id_sucursal, p.usuario, p.fecha_inicio, p.fecha_fin "
      . "from planilla as p "
      . "inner join clientes as c on c.id = p.cliente "
      . "inner join entidad as e on e.ruc = c.ruc "
      . "inner join sucursal_cliente as sc on sc.cliente = p.cliente and sc.id = p.sucursal "
      . "where p.estado = '" . $this->estado . "' "
      . "order by p.codigo desc";
     */

    function ver_datos_planilla() {
        global $conn;
        $query = "select p.codigo, p.anio, p.semana, e.nombre_comercial, sc.nombre as sucursal, p.cliente as id_cliente, p.sucursal as id_sucursal, p.usuario, p.fecha_inicio, p.fecha_fin, p.alimentacion, col.nombres, p.local, p.estado, "
                . "ifnull (sum(dp.horas_normal / 8 * dp.jornal + IF(dp.horas_normal / 8 = 6, dp.jornal, 0) + (dp.jornal / 8 * 1.25 * dp.horas_25) + (dp.jornal / 8 * 2 * dp.horas_100) + "
                . "dp.i_alimentacion + dp.i_gastos - dp.d_adelanto - dp.d_otros), 0) as planilla "
                . "from planilla as p "
                . "left join detalle_planilla as dp on dp.planilla = p.codigo "
                . "inner join clientes as c on c.id = p.cliente "
                . "left join colaborador as co on co.id = dp.colaborador "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = p.cliente and sc.id = p.sucursal "
                . "inner join usuarios as u on u.usuario = p.usuario "
                . "inner join colaborador as col on col.id = u.colaborador "
                . "where p.codigo = '" . $this->codigo . "'";
       // echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
