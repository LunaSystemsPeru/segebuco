<?php
require_once 'Conectar.php';

class Sedes
{
    private $id;
    private $direccion;
    private $ubigeo;
    private $conectar;

    function __construct()
    {
        $this->conectar =  conectar::getInstancia();
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setUbigeo($ubigeo)
    {
        $this->ubigeo = $ubigeo;
    }
    public function getUbigeo()
    {
        return $this->ubigeo;
    }

    public function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM sedes";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    public function insertar()
    {
        $sql = "INSERT INTO sedes VALUE (
            '$this->id',
            '$this->direccion',
            '$this->ubigeo'
            )";
        return $this->conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "SELECT * FROM sedes WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if ($fila) {
            $this->id = $fila['id'];
            $this->direccion = $fila['direccion'];
            $this->ubigeo = $fila['ubigeo'];
        }
    }

    public function verFilas()
    {
        $sql = "SELECT * FROM sedes";
        $fila = $this->conectar->get_Row($sql);
    }
}
