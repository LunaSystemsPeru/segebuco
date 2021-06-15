<?php

include_once 'cl_conectar.php';

class cl_compra_amarre
{
private $id_compra;
private $periodo;
private $id_tido;
private $fecha;
private $serie;
private $numero;

    /**
     * cl_compra_amarre constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdCompra()
    {
        return $this->id_compra;
    }

    /**
     * @param mixed $id_compra
     */
    public function setIdCompra($id_compra)
    {
        $this->id_compra = $id_compra;
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
            . "from compras_amarre "
            . "where idcompra = '$this->id_compra' and periodo = '$this->periodo'";
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
        $query = "insert into compras_amarre values ('$this->id_compra', '$this->periodo', ' $this->id_tido', '$this->serie', '$this->numero', '$this->fecha')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not insert data in compras_amarre: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
}