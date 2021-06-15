<?php

include_once 'cl_conectar.php';

class cl_venta_amarre
{
private $id_venta;
private $periodo;
private $id_tido;
private $fecha;
private $serie;
private $numero;

    /**
     * cl_venta_amarre constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdVenta()
    {
        return $this->id_venta;
    }

    /**
     * @param mixed $id_venta
     */
    public function setIdVenta($id_venta)
    {
        $this->id_venta = $id_venta;
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
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getIdTido()
    {
        return $this->id_tido;
    }

    /**
     * @param mixed $id_tido
     */
    public function setIdTido($id_tido)
    {
        $this->id_tido = $id_tido;
    }


    function obtener_datos() {
        $b_validar = false;
        global $conn;
        $query = "select * "
            . "from ventas_amarre "
            . "where idventa = '" . $this->id_venta . "' and periodo = '" . $this->periodo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $b_validar = true;
                $this->fecha = $fila ['fecha'];
                $this->serie = $fila ['serie'];
                $this->numero = $fila ['numero'];
                $this->id_tido = $fila ['id_tido'];
            }
        } else {
            $b_validar = false;
        }
        return $b_validar;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into ventas_amarre values ('" . $this->id_venta . "', '" . $this->fecha . "', '" . $this->id_tido . "', '" . $this->serie . "', '" . $this->numero . "', '$this->periodo')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not insert data in usuarios: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
}