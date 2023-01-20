<?php
require_once 'Conectar.php';

class TareaDiaria
{
    private $id;
    private $fecharegistro;
    private $fechainicio;
    private $fechatermino;
    private $idsupervisor;
    private $idmaestro;
    private $estado;
    private $idembarcacion;
    private $descripcion;
    private $direccion;
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
    public function getIdsupervisor()
    {
        return $this->idsupervisor;
    }

    /**
     * @param mixed $idsupervicion
     */
    public function setIdsupervisor($idsupervisor)
    {
        $this->idsupervisor = $idsupervisor;
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
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM tareas_diarias";
        $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO tareas_diarias VALUE(
            '$this->id',
            '$this->fecharegistro',
            '$this->fechainicio',
            '$this->fechatermino',
            '$this->idsupervisor',
            '$this->idmaestro',
            '$this->estado',
            '$this->idembarcacion',
            '$this->descripcion',
            '$this->direccion'
        )";
        $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE tareas_diarias SET
        fecha_registro = '$this->fecharegistro',
        fec_inicio = '$this->fechainicio',
        fec_termino = '$this->fechatermino',
        supervisorid = '$this->idsupervisor',
        maestroid = '$this->idmaestro',
        estado = '$this->estado',
        embarcacionid = '$this->idembarcacion',
        descripcion = '$this->descripcion',
        direccion = '$this->direccion',";
        $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM tareas_diarias WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->fecharegistro = $fila['fecha_registro'];
            $this->fechainicio = $fila['fec_inico'];
            $this->fechatermino = $fila['fec_termino'];
            $this->idsupervisor = $fila['supervisorid'];
            $this->idmaestro = $fila['maestroid'];
            $this->estado = $fila['estado'];
            $this->idembarcacion = $fila['embarcacionid'];
            $this->descripcion = $fila['descripcion'];
            $this->direccion = $fila['direccion'];
        }
    }

    function verFilas(){
        $sql = "SELECT * FROM tareas_diaria";
        $this->conectar->get_Cursor($sql);
    }
}
