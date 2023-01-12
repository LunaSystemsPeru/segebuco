<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 01/07/19
 * Time: 02:17 PM
 */

class cl_ajuste_materiales
{

    private $id_ajuste;
    private $anio;
    private $id_material;
    private $costo;
    private $csistema;
    private $cencontrado;

    /**
     * cl_ajuste_materiales constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdAjuste()
    {
        return $this->id_ajuste;
    }

    /**
     * @param mixed $id_ajuste
     */
    public function setIdAjuste($id_ajuste)
    {
        $this->id_ajuste = $id_ajuste;
    }

    /**
     * @return mixed
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @param mixed $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    /**
     * @return mixed
     */
    public function getIdMaterial()
    {
        return $this->id_material;
    }

    /**
     * @param mixed $id_material
     */
    public function setIdMaterial($id_material)
    {
        $this->id_material = $id_material;
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
    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    /**
     * @return mixed
     */
    public function getCsistema()
    {
        return $this->csistema;
    }

    /**
     * @param mixed $csistema
     */
    public function setCsistema($csistema)
    {
        $this->csistema = $csistema;
    }

    /**
     * @return mixed
     */
    public function getCencontrado()
    {
        return $this->cencontrado;
    }

    /**
     * @param mixed $cencontrado
     */
    public function setCencontrado($cencontrado)
    {
        $this->cencontrado = $cencontrado;
    }

        function insertar()
    {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_ajuste_materiales 
        values ('" . $this->id_ajuste . "', '" . $this->anio . "',  '" . $this->id_material . "', '" . $this->costo . "',  '" . $this->csistema . "', '" . $this->cencontrado . "')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in detalle_ajuste_materiales: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_materiales() {
        global $conn;
        $query = "select dam.id_material, dam.costo, dam.csistema, dam.cencontrado, m.descripcion
        from detalle_ajuste_materiales as dam 
        inner join material as m on m.idMaterial = dam.id_material
        where dam.id_ajuste = '".$this->id_ajuste."' and dam.anio = '".$this->anio."'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}