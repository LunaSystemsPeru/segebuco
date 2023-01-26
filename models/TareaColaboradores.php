<?php
require_once 'Conectar.php';

class TareaColaboradores{
    private $id;
    private $idtarea;
    private $idcolaborador;
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
    public function getIdtarea()
    {
        return $this->idtarea;
    }

    /**
     * @param mixed $idtarea
     */
    public function setIdtarea($idtarea)
    {
        $this->idtarea = $idtarea;
    }

    /**
     * @return mixed
     */
    public function getIdcolaborador()
    {
        return $this->idcolaborador;
    }

    /**
     * @param mixed $idcolaborador
     */
    public function setIdcolaborador($idcolaborador)
    {
        $this->idcolaborador = $idcolaborador;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM tareas_colaboradores";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO tareas_colaboradores VALUE(
            '$this->id',
            '$this->idtarea',
            '$this->idcolaborador'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE tareas_colaboradores SET
        tareaid = '$this->idtarea',
        colaboradorid = '$this->idcolaborador'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM tareas_colaboradores WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->id = $fila['id'];
            $this->idtarea = $fila['tareaid'];
            $this->idcolaborador = $fila['colaboradorid'];
        }
    }

    function verFilas(){
        $sql = "SELECT * FROM tareas_colaboradores";
        return $this->conectar->get_Cursor($sql);
    }
}