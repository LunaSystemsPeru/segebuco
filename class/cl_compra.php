<?php

include 'cl_conectar.php';

class cl_compra {

    private $codigo;
    private $periodo;
    private $fecha_compra;
    private $proveedor;
    private $moneda;
    private $tc;
    private $total;
    private $igv;
    private $tido;
    private $serie;
    private $numero;
    private $glosa;
    private $id_orden;
    private $porcentaje;
    private $id_centro_costo;
    private $id_clasificacion;
    private $estado;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getFecha_compra() {
        return $this->fecha_compra;
    }

    function getProveedor() {
        return $this->proveedor;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getTc() {
        return $this->tc;
    }

    function getTotal() {
        return $this->total;
    }

    function getTido() {
        return $this->tido;
    }

    function getSerie() {
        return $this->serie;
    }

    function getNumero() {
        return $this->numero;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setFecha_compra($fecha_compra) {
        $this->fecha_compra = $fecha_compra;
    }

    function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setTc($tc) {
        $this->tc = $tc;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setTido($tido) {
        $this->tido = $tido;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function getGlosa() {
        return $this->glosa;
    }

    function setGlosa($glosa) {
        $this->glosa = $glosa;
    }

    function getId_orden() {
        return $this->id_orden;
    }

    function getId_centro_costo() {
        return $this->id_centro_costo;
    }

    function getId_clasificacion() {
        return $this->id_clasificacion;
    }

    function setId_orden($id_orden) {
        $this->id_orden = $id_orden;
    }

    function setId_centro_costo($id_centro_costo) {
        $this->id_centro_costo = $id_centro_costo;
    }

    function setId_clasificacion($id_clasificacion) {
        $this->id_clasificacion = $id_clasificacion;
    }

    function getPorcentaje() {
        return $this->porcentaje;
    }

    function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    /**
     * @return mixed
     */
    public function getIgv()
    {
        return $this->igv;
    }

    /**
     * @param mixed $igv
     */
    public function setIgv($igv)
    {
        $this->igv = $igv;
    }

    function i_compra() {
        $grabado = false;
        global $conn;
        $query = "insert into compras values ('" . $this->codigo . "', '" . $this->periodo . "',  '" . $this->fecha_compra . "', '" . $this->proveedor . "',  '" . $this->moneda . "', "
                . "'" . $this->tc . "', '" . $this->total . "', '" . $this->igv . "', '" . $this->tido . "', '" . $this->serie . "', '" . $this->numero . "', '" . $this->glosa . "', '" . $this->id_orden . "', "
                . "'" . $this->porcentaje . "', '" . $this->id_centro_costo . "', '" . $this->id_clasificacion . "', '0', NOW())";
        $resultado = $conn->query($query);
        //echo $query;
        if (!$resultado) {
            die('Could not enter data in compras: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(codigo) + 1, 1) as codigo 
                from compras  
                where periodo = '$this->periodo' ";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function ver_compras() {
        global $conn;
        $query = "select c.codigo, c.periodo, c.fecha_compra,  c.serie, c.numero, c.total, c.igv, c.tipo_documento, td.abreviado as tido, td.sunat, dtgm.atributo as moneda, c.moneda as id_moneda, c.tipo_cambio, c.estado, c.ruc_proveedor, e.razon_social as proveedor "
                . "from compras as c "
                . "inner join tipo_documento as td on td.id = c.tipo_documento "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = c.moneda "
                . "inner join entidad as e on e.ruc = c.ruc_proveedor "
                . "where c.periodo = '" . $this->periodo . "' "
                . "order by c.fecha_compra asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_compras_periodo() {
        global $conn;
        $query = "SELECT periodo, SUM( tipo_cambio * total ) AS total "
                . "FROM compras where year(fecha_compra) = year(now()) "
                . "GROUP BY periodo";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_periodos() {
        global $conn;
        $query = "select distinct periodo "
                . "from compras "
                . "where periodo < '" . $this->periodo . "' "
                . "order by periodo desc";
        echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_datos_compra($codigo) {
        global $conn;
        $query = "select c.codigo, c.periodo, c.fecha_compra, c.ruc_proveedor, e.razon_social, dtgm.descripcion as nmoneda, dtgm.atributo as moneda, "
                . "c.total, td.abreviado as ndocumento, c.serie, c.numero, c.glosa, c.id_centro_costo, c.id_clasificacion "
                . "from compras as c "
                . "inner join entidad as e on e.ruc = c.ruc_proveedor "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = c.moneda "
                . "inner join tipo_documento as td on td.id = c.tipo_documento "
                . "where concat (c.periodo, c.codigo) = '" . $codigo . "' ";
        // echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function validar_compra() {
        $existe = false;
        global $conn;
        $query = "select codigo, periodo "
                . "from compras "
                . "where ruc_proveedor = '" . $this->proveedor . "' and tipo_documento = '" . $this->tido . "' and serie = '" . $this->serie . "' and numero = '" . $this->numero . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->periodo = $fila['periodo'];
                $this->codigo = $fila['codigo'];
                $existe = true;
            }
        }
        return $existe;
    }
    function obtener_datos() {
        $existe = false;
        global $conn;
        $query = "SELECT * FROM compras WHERE codigo='$this->getCodigo()' and periodo = '$this->periodo'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->fecha_compra=$fila["fecha_compra"];
                $this->proveedor=$fila["ruc_proveedor"];
                $this->moneda=$fila["moneda"];
                $this->tc=$fila["tipo_cambio"];
                $this->total=$fila["total"];
                $this->tido=$fila["tipo_documento"];
                $this->serie=$fila["serie"];
                $this->numero=$fila["numero"];
                $this->glosa=$fila["glosa"];
                $this->id_orden=$fila["id_orden"];
                $this->porcentaje=$fila["porcentaje"];
                $this->id_centro_costo=$fila["id_centro_costo"];
                $this->id_clasificacion=$fila["id_clasificacion"];
                $this->estado=$fila["estado"];
                $existe = true;
            }
        }
        return $existe;
    }
    
    function eliminar() {
        $eliminado = false;
        global $conn;
        $query = "delete from compras "
                . "where periodo = '" . $this->periodo . "' and codigo = '".$this->codigo."'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in compras: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $eliminado = true;
        }
        return $eliminado;
    }

}
