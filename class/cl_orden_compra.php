<?php

/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 10/02/2019
 * Time: 03:57 AM
 */
include 'cl_conectar.php';

class cl_orden_compra {

    private $anio;
    private $id;
    private $fecha;
    private $id_proveedor;
    private $id_moneda;
    private $monto;
    private $glosa;
    private $porcentaje;

    /**
     * cl_orden_compra constructor.
     */
    public function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getAnio() {
        return $this->anio;
    }

    /**
     * @param mixed $anio
     */
    public function setAnio($anio) {
        $this->anio = $anio; ///ss
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getIdProveedor() {
        return $this->id_proveedor;
    }

    /**
     * @param mixed $id_proveedor
     */
    public function setIdProveedor($id_proveedor) {
        $this->id_proveedor = $id_proveedor;
    }

    /**
     * @return mixed
     */
    public function getIdMoneda() {
        return $this->id_moneda;
    }

    /**
     * @param mixed $id_moneda
     */
    public function setIdMoneda($id_moneda) {
        $this->id_moneda = $id_moneda;
    }

    /**
     * @return mixed
     */
    public function getMonto() {
        return $this->monto;
    }

    /**
     * @param mixed $monto
     */
    public function setMonto($monto) {
        $this->monto = $monto;
    }

    /**
     * @return mixed
     */
    public function getGlosa() {
        return $this->glosa;
    }

    /**
     * @param mixed $glosa
     */
    public function setGlosa($glosa) {
        $this->glosa = $glosa;
    }

    /**
     * @return mixed
     */
    public function getPorcentaje() {
        return $this->porcentaje;
    }

    /**
     * @param mixed $porcentaje
     */
    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }
    
    function cargar_datos($codigo) {
        $existe = false;
        global $conn;
        $query = "select * "
                . "from orden_compra "
                . "where concat(anio, id) = '".$codigo."'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $existe = true;
                $this->id = $fila ['id'];
                $this->anio = $fila ['anio'];
                $this->id_proveedor = $fila ['id_proveedor'];
                $this->fecha = $fila ['fecha'];
                $this->id_moneda = $fila ['id_moneda'];
                $this->monto = $fila ['monto'];
                $this->glosa = $fila ['descripcion'];
                $this->porcentaje = $fila ['facturado'];
            }
        }
        return $existe;
    }

    function obtener_id() {
        global $conn;
        $query = "select ifnull(max(id) + 1, 1) as codigo from orden_compra where anio = '" . $this->anio . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id = $fila ['codigo'];
            }
        }
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into orden_compra values ('" . $this->anio . "', '" . $this->id . "',  '" . $this->id_proveedor . "', '" . $this->fecha . "',  '" . $this->id_moneda . "', "
                . "'" . $this->monto . "', '" . $this->glosa . "', '0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in orden_compra: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_periodos() {
        global $conn;
        $query = "select distinct anio from orden_compra order by anio desc";
        echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_ordenes() {
        global $conn;
        $query = "select oc.anio, oc.id, oc.proveedor, e.razon_social, oc.fecha, dtgm.atributo as nmoneda, oc.monto, oc.facturado "
                . "from orden_compra as oc "
                . "inner join entidad as e on e.ruc = oc.proveedor "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = oc.id_moneda";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_ordenes_proveedor() {
        global $conn;
        $query = "select oc.anio, oc.id, oc.fecha, dtgm.atributo as nmoneda, oc.monto, oc.facturado, oc.descripcion "
                . "from orden_compra as oc "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = oc.id_moneda "
                . "where oc.proveedor = '" . $this->id_proveedor . "' "
                . "order by oc.fecha desc ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
