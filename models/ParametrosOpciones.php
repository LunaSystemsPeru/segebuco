<?php
require_once 'Conectar.php';

class ParametrosOpciones{
    private $id;
    private $descripcion;
    private $valor1;
    private $valor2;
    private $idparametro;
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

    /**
     * @return mixed
     */
    public function getValor1()
    {
        return $this->valor1;
    }

    /**
     * @param mixed $valor1
     */
    public function setValor1($valor1)
    {
        $this->valor1 = $valor1;
    }

    /**
     * @return mixed
     */
    public function getValor2()
    {
        return $this->valor2;
    }

    /**
     * @param mixed $valor2
     */
    public function setValor2($valor2)
    {
        $this->valor2 = $valor2;
    }

    /**
     * @return mixed
     */
    public function getIdparametro()
    {
        return $this->idparametro;;
    }

    /**
     * @param mixed $idparametro
     */
    public function setIdparametro($idparametro)
    {
        $this->idparametro = $idparametro;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM parametros_opciones";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO parametros_opciones VALUE(
            '$this->id',
            '$this->descripcion',
            '$this->valor1',
            '$this->valor2',
            '$this->idparametro'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE parametros_opciones SET
        fecha_registro = '$this->descripcion',
        fec_inicio = '$this->valor1',
        fec_termino = '$this->valor2',
        supervisorid = '$this->idparametro'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM parametros_opciones WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->descripcion = $fila['descripcion'];
            $this->valor1 = $fila['valor1'];
            $this->valor2 = $fila['valor2'];
            $this->idparametro = $fila['parametroid'];
        }
    }

    function verFilas(){
        $sql = "SELECT * FROM parametros_opciones WHERE parametroid = '$this->idparametro'";
        return $this->conectar->get_Cursor($sql);
    }
}