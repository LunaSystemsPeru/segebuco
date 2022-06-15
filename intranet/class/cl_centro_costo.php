<?php

require 'cl_conectar.php';

class cl_centro_costo {

    private $cliente;
    private $sucursal;
    private $anio;
    private $codigo;
    private $nombre;
    private $presupuesto;
    private $caja;
    private $planilla;
    private $gdocumentado;
    private $gsimple;
    private $estado;

    function __construct() {

    }

    function getProyecto() {
        return $this->proyecto;
    }

    function getAnio() {
        return $this->anio;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {
        return $this->estado;
    }

    function getPlanilla() {
        return $this->planilla;
    }

    function getGdocumentado() {
        return $this->gdocumentado;
    }

    function getGsimple() {
        return $this->gsimple;
    }

    function setPlanilla($planilla) {
        $this->planilla = $planilla;
    }

    function setGdocumentado($gdocumentado) {
        $this->gdocumentado = $gdocumentado;
    }

    function setGsimple($gsimple) {
        $this->gsimple = $gsimple;
    }

    function setProyecto($proyecto) {
        $this->proyecto = $proyecto;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * @param mixed $sucursal
     */
    public function setSucursal($sucursal)
    {
        $this->sucursal = $sucursal;
    }

    /**
     * @return mixed
     */
    public function getPresupuesto()
    {
        return $this->presupuesto;
    }

    /**
     * @param mixed $presupuesto
     */
    public function setPresupuesto($presupuesto)
    {
        $this->presupuesto = $presupuesto;
    }

    /**
     * @return mixed
     */
    public function getCaja()
    {
        return $this->caja;
    }

    /**
     * @param mixed $caja
     */
    public function setCaja($caja)
    {
        $this->caja = $caja;
    }

    function ver_centros() {
        global $conn;
        $query = "select cp.anio, cp.codigo, cp.descripcion, cp.estado, cp.presupuesto, cp.caja, cp.planilla, cp.gastos_documentados, cp.gastos_simples "
                . "from centro_costes as cp "
                . "where cp.estado = '1' "
                . "order by cp.descripcion asc";
         //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_resumen_proyecto() {
        global $conn;
        $query = "select sum(planilla) as splanilla, sum(gastos_documentados) as sgastos_documentados, sum(gastos_simples) as sgastos_simples "
                . "from centro_costes "
                . "where proyecto = '" . $this->proyecto . "'";
        // echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function sumar_gastos($codigo) {
        $grabado = false;
        global $conn;
        $query = "update centro_costes "
                . "set planilla = planilla + '" . $this->planilla . "', gastos_simples =  gastos_simples + '" . $this->gsimple . "', gastos_documentados = gastos_documentados + '" . $this->gdocumentado . "' "
                . "where concat(anio, codigo) = '" . $codigo . "'";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not modify data in costo_proyecto: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function restar_gastos() {
        $grabado = false;
        global $conn;
        $query = "update centro_costes "
                . "set planilla = planilla - '" . $this->planilla . "', gastos_simples =  gastos_simples - '" . $this->gsimple . "', gastos_documentados = gastos_documentados - '" . $this->gdocumentado . "' "
                . "where codigo = '" . $this->codigo . "'";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not modify data in costo_proyecto: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_datos() {
        $existe = false;
        global $conn;
        $query = "select * "
            . "from centro_costes "
            . "where anio = '".$this->anio."' and codigo = '".$this->codigo."'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila ['descripcion'];
                $this->cliente = $fila ['id_cliente'];
                $this->sucursal = $fila ['id_sucursal'];
                $this->presupuesto = $fila ['presupuesto'];
                $this->caja = $fila ['caja'];
                $this->planilla = $fila ['planilla'];
                $this->gdocumentado = $fila ['gastos_documentados'];
                $this->gsimple = $fila ['gastos_simples'];
                $this->estado = $fila ['estado'];
            }
        }
        return $existe;
    }

}
