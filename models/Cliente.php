<?php
require_once 'Conectar.php';

class Cliente
{
    private $idcliente;
    private $documento;
    private $nombre;
    private $direccion;
    private $nombrecorto;
    private $conectar;

    /**
     * Cliente constructor.
     */
    public function __construct()
    {
        $this->conectar = conectar::getInstancia();
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
    public function setIdcliente($idcliente): void
    {
        $this->idcliente = $idcliente;
    }

    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param mixed $documento
     */
    public function setDocumento($documento): void
    {
        $this->documento = $documento;
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
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
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
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getNombrecorto()
    {
        return $this->nombrecorto;
    }

    /**
     * @param mixed $nombrecorto
     */
    public function setNombrecorto($nombrecorto): void
    {
        $this->nombrecorto = $nombrecorto;
    }

    public function obtenerId()
    {
        $sql = "select ifnull(max(id) + 1, 1) as codigo 
            from clientes";
        $this->idcliente = $this->conectar->get_valor_query($sql, 'codigo');
    }

    public function insertar()
    {
        $sql = "insert into clientes 
        values ('$this->idcliente', 
                '$this->nombre',
                '$this->nombrecorto',
                '$this->documento',   
                '$this->direccion')";
        return $this->conectar->ejecutar_idu($sql);
    }

    public function modificar()
    {
        $sql = "update clientes 
        set razon_social = '$this->nombre', 
            nombre_corto = '$this->nombrecorto', 
            nro_documento = '$this->documento', 
            direccion_fiscal = '$this->direccion'
        where id = '$this->idcliente'";
        return $this->conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from clientes 
        where id = '$this->idcliente'";
        $fila = $this->conectar->get_Row($sql);
        if ($fila) {
            $this->idcliente = $fila['id_cliente'];
            $this->documento = $fila['nro_documento'];
            $this->nombre = $fila['razon_social'];
            $this->nombrecorto = $fila['nombre_corto'];
            $this->direccion = $fila['direccion_fiscal'];
        }
    }

    public function verFilas()
    {
        $sql = "select * from clientes 
                order by razon_social asc";
        return $this->conectar->get_Cursor($sql);
    }

    public function buscarClientes($term) {
        $sql = "select * 
        from clientes 
        where nro_documento like '%$term%' or razon_social like '%$term%'  
        order by razon_social asc
        limit 30";
        return $this->conectar->get_Cursor($sql);
    }

}