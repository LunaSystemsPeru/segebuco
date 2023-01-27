<?php
require_once 'Conectar.php';

class Colaboradores {
    private $id;
    private $datos;
    private $idcargo;
    private $iddocumentotipo;
    private $nrodocumento;
    private $fecha;
    private $estado;
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
     * @param mixed $idcargo
     */
    public function setIdcargo($idcargo)
    {
        $this->idcargo = $idcargo;
    }
    /**
     * @return mixed
     */
    public function getIddocumentotipo()
    {
        return $this->iddocumentotipo;
    }

    /**
     * @param mixed $iddocumentotipo
     */
    public function setIddocumentotipo($iddocumentotipo)
    {
        $this->iddocumentotipo = $iddocumentotipo;
    }
    /**
     * @return mixed
     */
    public function getNrodocumento()
    {
        return $this->nrodocumento;
    }

    /**
     * @param mixed $nrodocumento
     */
    public function setNrodocumento($nrodocumento)
    {
        $this->nrodocumento = $nrodocumento;
    }
    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $fecha
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM colaboradores";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO colaboradores VALUE(
            '$this->id',
            '$this->datos',
            '$this->idcargo',
            '$this->iddocumentotipo',
            '$this->nrodocumento',
            '$this->fecha',
            '$this->estado'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE colaboradores SET
        datos = '$this->datos',
        cargoid = '$this->idcargo',
        documento_tipo_id = '$this->iddocumentotipo',
        documento_nro = '$this->nrodocumento',
        fecha_nacimiento = '$this->fecha',
        estado = '$this->estado'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificarEstado(){
        $sql = "UPDATE colaboradores SET
        estado = '$this->estado'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM colaboradores WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->datos = $fila['datos'];
            $this->idcargo = $fila['cargoid'];
            $this->iddocumentotipo = $fila['documento_tipo_id'];
            $this->nrodocumento = $fila['documento_nro'];
            $this->fecha = $fila['fecha_nacimiento'];
            $this->estado = $fila['estado'];
        }
    }

    function verFilas(){
        $sql = "SELECT * FROM colaboradores WHERE cargoid = '$this->idcargo' AND estado = '$this->estado'";
        return $this->conectar->get_Cursor($sql);
    }

    function verObreros(){
        $sql = "SELECT * FROM colaboradores WHERE cargoid != '$this->idcargo' AND estado = '$this->estado'";
        return $this->conectar->get_Cursor($sql);
    }
}