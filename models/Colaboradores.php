<?php
require_once 'Conectar.php';

class Colaboradores {
    private $id;
    private $datos;
    private $idcargo;
    private $conectar;

    function __construct()
    {
        $this->conectar = conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed  $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * @param mixed $datos
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;
    }

    /**
     * @return mixed
     */
    public function getIdcargo()
    {
        return $this->idcargo;
    }

    /**
     * @param mixed $fechainicio
     */
    public function setIdcargo($idcargo)
    {
        $this->idcargo = $idcargo;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM colaboradores";
        $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO colaboradores VALUE(
            '$this->id',
            '$this->datos',
            '$this->idcargo'
        )";
        $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE colaboradores SET
        datos = '$this->datos',
        cargoid = '$this->idcargo'";
        $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM colaboradores WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->datos = $fila['datos'];
            $this->idcargo = $fila['cargoid'];
        }
    }

    function verFilas(){
        $sql = "SELECT * FROM colaboradores";
        $this->conectar->get_Cursor($sql);
    }
}