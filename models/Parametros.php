<?php
require_once 'Conectar.php';

class Parametros {
    private $id;
    private $descripcion;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM parametros";
        $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO parametros VALUE(
            '$this->id',
            '$this->descripcion'
        )";
        $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE parametros SET
        descripcion = '$this->descripcion'";
        $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM parametros WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->descripcion = $fila['descripcion'];
        }
    }

    function verFilas(){
        $sql = "SELECT * FROM parametros";
        $this->conectar->get_Cursor($sql);
    }
}