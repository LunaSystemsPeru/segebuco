<?php

require 'cl_conectar.php';

class cl_retornos {

    private $codigo;
    private $periodo;
    private $fecha;
    private $usuario;
    private $origen;
    private $destino;

    function __construct() {

    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param mixed $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * @param mixed $origen
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;
    }

    /**
     * @return mixed
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * @param mixed $destino
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

     function ver_retornos() {
        global $conn;
        $query = "select r.id_retorno, r.periodo, r.fecha, r.usuario, ao.nombre as origen, ad.nombre as destino "
            . "from retorno as r "
            . "inner join almacen as ao on ao.codigo = r.almacen_origen "
            . "inner join almacen as ad on ad.codigo = r.almacen_destino "
            . "where r.periodo = '" . $this->periodo . "' "
            . "order by r.fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(id_retorno) + 1, 1) as codigo from retorno where periodo = '" . $this->periodo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into retorno "
                . "values ('" . $this->codigo . "', '" . $this->periodo . "',  '" . $this->fecha . "', '" . $this->usuario . "',  '" . $this->origen . "', "
            . "'" . $this->destino . "', now())";
        $resultado = $conn->query($query);
        echo $query . "<br>";
        if (!$resultado) {
            die('Could not enter data in retorno: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_periodo() {
        global $conn;
        $query = "SELECT periodo FROM retorno GROUP BY periodo order by periodo desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
