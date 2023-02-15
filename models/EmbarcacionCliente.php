<?php
require_once 'Conectar.php';

class EmbarcacionCliente{
    private $id;
    private $razonsocial;
    private $nombre;
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
    public function getRazonsocial()
    {
        return $this->razonsocial;;
    }

    /**
     * @param mixed $razonsocial
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM clientes";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO clientes VALUE(
            '$this->id',
            '$this->razonsocial',
            '$this->nombre'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE clientes SET
        datos = '$this->razonsocial',
        cargoid = '$this->nombre'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM clientes WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->razonsocial = $fila['razon_social'];
            $this->nombre = $fila['nombre_corto'];
        }
    }

    function verFilas(){
        $sql = "SELECT * FROM clientes";
        return $this->conectar->get_Cursor($sql);
    }
}
