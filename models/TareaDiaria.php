<?php
require_once 'Conectar.php';

class TareaDiaria
{
    private $id;
    private $fecharegistro;
    private $fechainicio;
    private $fechatermino;
    private $idmaestro;
    private $estado;
    private $idembarcacion;
    private $motorista;
    private $descripcion;
    private $guia;
    private $idcotizacion;
    private $idtiposervicio;
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
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    /**
     * @param mixed $fecharegistro
     */
    public function setFecharegistro($fecharegistro)
    {
        $this->fecharegistro = $fecharegistro;
    }

    /**
     * @return mixed
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * @param mixed $fechainicio
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;
    }

    /**
     * @return mixed
     */
    public function getFechatermino()
    {
        return $this->fechatermino;
    }

    /**
     * @param mixed $fechatermino
     */
    public function setFechatermino($fechatermino)
    {
        $this->fechatermino = $fechatermino;
    }

    /**
     * @return mixed
     */
    public function getIdcotizacion()
    {
        return $this->idcotizacion;
    }

    /**
     * @param mixed $idcotizacion
     */
    public function setIdcotizacion($idcotizacion)
    {
        $this->idcotizacion = $idcotizacion;
    }

    /**
     * @return mixed
     */
    public function getIdmaestro()
    {
        return $this->idmaestro;
    }

    /**
     * @param mixed $idmestro
     */
    public function setIdmaestro($idmaestro)
    {
        $this->idmaestro = $idmaestro;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getIdembarcacion()
    {
        return $this->idembarcacion;
    }

    /**
     * @param mixed $idembarcacion
     */
    public function setIdembarcacion($idembarcacion)
    {
        $this->idembarcacion = $idembarcacion;
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

    /**
     * @return mixed
     */
    public function getGuia()
    {
        return $this->guia;
    }

    /**
     * @param mixed $guia
     */
    public function setGuia($guia)
    {
        $this->guia = $guia;
    }

    /**
     * @return mixed
     */
    public function getMotorista()
    {
        return $this->motorista;
    }

    /**
     * @param mixed $motorista
     */
    public function setMotorista($motorista)
    {
        $this->motorista = $motorista;
    }

    /**
     * @return mixed
     */
    public function getIdTiposervicio()
    {
        return $this->idtiposervicio;
    }

    /**
     * @param mixed $idtiposervicio
     */
    public function setIdtiposervicio($idtiposervicio)
    {
        $this->idtiposervicio = $idtiposervicio;
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
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM tareas_diarias";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO tareas_diarias VALUE(
            '$this->id',
            current_timestamp(),
            '$this->fechainicio',
            '$this->fechatermino',
            '$this->idmaestro',
            '$this->estado',
            '$this->idembarcacion',
            '$this->motorista',
            '$this->descripcion',
            '-',
            '0',
            '$this->idtiposervicio',
            '$this->nombre'
        )";
        //echo $sql;

        return $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE tareas_diarias SET
        fecha_registro = current_timestamp(),
        fec_inicio = '$this->fechainicio',
        fec_termino = '$this->fechatermino',
        maestroid = '$this->idmaestro',
        estado = '$this->estado',
        embarcacionid = '$this->idembarcacion',
        motorista_datos = '$this->motorista',
        descripcion = '$this->descripcion',
        guia_nro = '$this->guia',
        cotizacionid = '$this->idcotizacion',
        tiposervicioid = '$this->idtiposervicio',
        nombre_corto = '$this->nombre'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificarEstado()
    {
        $sql = "UPDATE tareas_diarias SET
        estado = '$this->estado',
        cotizacionid = '$this->idcotizacion'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos()
    {
        $sql = "SELECT * FROM tareas_diarias WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if ($fila) {
            $this->id = $fila['id'];
            $this->fecharegistro = $fila['fecha_registro'];
            $this->fechainicio = $fila['fec_inicio'];
            $this->fechatermino = $fila['fec_termino'];
            $this->idmaestro = $fila['maestroid'];
            $this->estado = $fila['estado'];
            $this->idembarcacion = $fila['embarcacionid'];
            $this->motorista = $fila['motorista_datos'];
            $this->descripcion = $fila['descripcion'];
            $this->guia = $fila['guia_nro'];
            $this->idcotizacion = $fila['cotizacionid'];
            $this->idtiposervicio = $fila['tiposervicioid'];
            $this->nombre = $fila['nombre_corto'];
        }
    }

    function verFilas()
    {
        $sql = "select td.id, td.fecha_registro, td.nombre_corto, td.fec_inicio, td.estado, td.embarcacionid, e.nombre as nep, c.nombre_corto as ncliente, pd.descripcion as tiposervicio, td.guia_nro, co.datos
from tareas_diarias as td 
inner join embarcacion as e on e.id = td.embarcacionid
inner join colaboradores as co on co.id = td.maestroid
inner join clientes as c on c.id = e.clienteid
inner join parametros_opciones as pd on pd.id = td.tiposervicioid
where td.estado = 0";
        return $this->conectar->get_Cursor($sql);
    }
    function verTareas()
    {
        $sql = "select td.id, td.fecha_registro, td.nombre_corto, td.fec_inicio, td.estado, td.embarcacionid, e.nombre as nep, c.nombre_corto as ncliente, pd.descripcion as tiposervicio, td.guia_nro, co.datos
from tareas_diarias as td 
inner join embarcacion as e on e.id = td.embarcacionid
inner join colaboradores as co on co.id = td.maestroid
inner join clientes as c on c.id = e.clienteid
inner join parametros_opciones as pd on pd.id = td.tiposervicioid";
        return $this->conectar->get_Cursor($sql);
    }
}
