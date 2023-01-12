<?php

include('cl_conectar.php');

class cl_material_compras
{
    private $materialid;
    private $costo;
    private $fecha;

    /**
     * cl_material_compras constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getMaterialid()
    {
        return $this->materialid;
    }

    /**
     * @param mixed $materialid
     */
    public function setMaterialid($materialid): void
    {
        $this->materialid = $materialid;
    }

    /**
     * @return mixed
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @param mixed $costo
     */
    public function setCosto($costo): void
    {
        $this->costo = $costo;
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
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    function insetar()
    {
        $grabado = false;
        global $conn;
        $query = "insert into material_coompra values (null, '$this->materialid', '$this->fecha', '$this->costo')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
}