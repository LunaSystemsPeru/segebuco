<?php
require_once 'Conectar.php';

class Embarcacion
{
    private $id;
    private $nombre;
    private $idcliente;
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

    /**
     * @return mixed
     */
    public function getIdcliente()
    {
        return $this->idcliente;
    }

    /**
     * @param mixed $idcliente
     */
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM embarcacion";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO embarcacion VALUE(
            '$this->id',
            '$this->nombre',
            '$this->idcliente'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE embarcacion SET
        nombre = '$this->nombre',
        clienteid = '$this->idcliente'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos()
    {
        $sql = "SELECT * FROM embarcacion WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if ($fila) {
            $this->id = $fila['id'];
            $this->nombre = $fila['nombre'];
            $this->idcliente = $fila['clienteid'];
        }
    }

    function verFilas()
    {
        $sql = "SELECT * FROM embarcacion order by nombre asc";
        return $this->conectar->get_Cursor($sql);
    }

    function verEmbarcacion()
    {
        $sql = "SELECT * FROM embarcacion WHERE nombre LIKE '%$this->nombre%'";
        return $this->conectar->get_Cursor($sql);
    }
}
