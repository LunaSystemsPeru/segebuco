<?php
require_once  'Conectar.php';

class OrdenServicioCliente
{
    private $id;
    private $nroorden;
    private $fechaorden;
    private $idmoneda;
    private $montoorden;
    private $estado;
    private $idcliente;
    private $nombre;
    private $idusuario;
    private $porcentaje;
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

    public function getNroorden()
    {
        return $this->nroorden;
    }

    public function setNroorden($nroorden)
    {
        $this->nroorden = $nroorden;
    }

    public function getFechaorden()
    {
        return $this->fechaorden;
    }
    public function setFechaorden($fechaorden)
    {
        $this->fechaorden = $fechaorden;
    }

    public function getIdmoneda()
    {
        return $this->idmoneda;
    }
    public function setIdmoneda($idmoneda)
    {
        $this->idmoneda = $idmoneda;
    }

    public function getMontoorden()
    {
        return $this->montoorden;
    }
    public function setMontoorden($montoorden)
    {
        $this->montoorden = $montoorden;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function getIdcliente()
    {
        return $this->idcliente;
    }
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getIdusuario()
    {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }

    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;
    }

    public function obtenerId()
    {
        $sql = 'SELECT IFNULL(MAX(id) + 1,1) AS codigo FROM orden_servicio_cliente';
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }
    public function insertar()
    {
        $sql = "INSERT INTO orden_servicio_cliente VALUES (
            '$this->id',
            '$this->nroorden',
            '$this->fechaorden',
            '$this->idmoneda',
            '$this->montoorden',
            '$this->estado',
            '$this->idcliente',
            '$this->nombre',
            '$this->idusuario',
            '$this->porcentaje'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }
    public function obtenerDatos()
    {
        $sql = "SELECT * FROM orden_servicio_cliente WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if ($fila) {
            $this->id = $fila['id'];
            $this->nroorden = $fila['nro_orden'];
            $this->fechaorden = $fila['fecha_orden'];
            $this->idmoneda = $fila['moneda_id'];
            $this->montoorden = $fila['monto_orden'];
            $this->estado = $fila['estado'];
            $this->idcliente = $fila['cliente_id'];
            $this->nombre = $fila['nombre_corto'];
            $this->idusuario = ['usuario_id'];
            $this->porcentaje = $fila['porcentaje'];
        }
    }
    public function verFilas()
    {
        $sql = "SELECT osc.id, osc.nro_orden as nro, osc.fecha_orden as fecha, po.valor1, po.valor2, osc.monto_orden as monto, osc.estado,  c.razon_social as cliente, osc.nombre_corte as nombre
        FROM orden_servicio_cliente osc
        INNER JOIN parametros_opciones as po ON po.id = osc.moneda_id
        INNER JOIN clientes AS c ON c.id = osc.cliente_id";
        return $this->conectar->get_Cursor($sql);
    }
}
