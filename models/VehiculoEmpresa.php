<?php
require_once 'Conectar.php';

class VehiculoEmpresa
{
    private $id;
    private $placa;
    private $marca;
    private $modelo;
    private $conectar;

    function __construct()
    {
        $this->conectar = conectar::getInstancia();
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }
    public function getPlaca()
    {
        return $this->placa;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }
    public function getMarca()
    {
        return $this->marca;
    }
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }
    public function getModelo()
    {
        return $this->modelo;
    }
    public function obtenerId()
    {
        $sql = 'SELECT IFNULL(MAX(id) + 1,1) AS codigo FROM vehiculos_empresa';
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }
    public function insertar()
    {
        $sql = "INSERT INTO vehiculos_empresa VALUES (
            '$this->id',
            '$this->placa',
            '$this->marca',
            '$this->modelo'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }
    public function obtenerDatos(){
        $sql = "SELECT * FROM vehiculos_empresa WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->placa = $fila['placa'];
            $this->marca = $fila['marca'];
            $this->modelo = $fila['modelo'];
        }
    }
    public function verFilas()
    {
        $sql = "SELECT * FROM vehiculos_empresa";
        return $this->conectar->get_Cursor($sql);
    }
}
