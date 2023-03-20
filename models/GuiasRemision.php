<?php
require_once 'Conectar.php';

class GuiasRemision
{
    private $id;
    private $fechaemision;
    private $serie;
    private $nro;
    private $idorigen;
    private $ubigeodestino;
    private $direcciondestino;
    private $opcion;
    private $idvehiculo;
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

    public function setFechaemision($fechaemision)
    {
        $this->fechaemision = $fechaemision;
    }
    public function getFechaemision()
    {
        return $this->fechaemision;
    }
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }
    public function getSerie()
    {
        return $this->serie;
    }
    public function setNro($nro)
    {
        $this->nro = $nro;
    }
    public function getNro()
    {
        return $this->nro;
    }
    public function setIdorigen($idorigen)
    {
        $this->idorigen = $idorigen;
    }
    public function getIdorigen()
    {
        return $this->idorigen;
    }
    public function setUbigeodestino($ubigeodestino)
    {
        $this->ubigeodestino = $ubigeodestino;
    }
    public function getUbigeodestino()
    {
        return $this->ubigeodestino;
    }
    public function setDirecciondestino($direcciondestino)
    {
        $this->direcciondestino = $direcciondestino;
    }
    public function getDirecciondestino()
    {
        return $this->direcciondestino;
    }
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;
    }
    public function getOpcion()
    {
        return $this->opcion;
    }

    public function setIdvehiculo($idvehiculo)
    {
        $this->idvehiculo = $idvehiculo;
    }

    public function getIdvehiculo()
    {
        return $this->idvehiculo;
    }

    public function obtenerId()
    {
        $sql = 'SELECT IFNULL(MAX(id) + 1,1) AS codigo FROM guias_remision';
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    public function insertar()
    {
        $sql = "INSERT INTO guias_remision values (
            '$this->id',
            '$this->fechaemision',
            '$this->serie',
            '$this->nro',
            '$this->idorigen',
            '$this->ubigeodestino',
            '$this->direcciondestino',
            '0',
            '$this->idvehiculo'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }
    public function obtenerDatos()
    {
        $sql = "SELECT * FROM guias_remision WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if ($fila) {
            $this->id = $fila['id'];
            $this->fechaemision = $fila['fecha_emision'];
            $this->serie = $fila['comprobante_serie'];
            $this->nro = $fila['comprobante_numero'];
            $this->idorigen = $fila['origenid'];
            $this->ubigeodestino = $fila['ubigeo_destino'];
            $this->direcciondestino = $fila['direccion_destino'];
            $this->opcion = $fila['opcion_mn'];
            $this->idvehiculo = $fila['vehiculoid'];
        }
    }
    public function verFilas()
    {
        $sql = "SELECT * FROM guias_remision";
        return $this->conectar->get_Row($sql);
    }
}
