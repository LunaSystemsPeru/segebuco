<?php
require_once 'Conectar.php';

class Cliente
{
    private $idcliente;
    private $nrodocumento;
    private $nombrecomercial;
    private $razonsocial;
    private $direccion;
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
    public function getNrodocumento()
    {
        return $this->nrodocumento;
    }

    /**
     * @param mixed $nrodocumento
     */
    public function setNrodocumento($nrodocumento): void
    {
        $this->nrodocumento = $nrodocumento;
    }

    /**
     * @return mixed
     */
    public function getNombrecomercial()
    {
        return $this->nombrecomercial;
    }

    /**
     * @param mixed $nombrecomercial
     */
    public function setNombrecomercial($nombrecomercial): void
    {
        $this->nombrecomercial = $nombrecomercial;
    }

    /**
     * @return mixed
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * @param mixed $razonsocial
     */
    public function setRazonsocial($razonsocial): void
    {
        $this->razonsocial = $razonsocial;
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
                '$this->razonsocial',
                '$this->nombrecomercial',
                '$this->nrodocumento',   
                '$this->irreccion')";
        return $this->conectar->ejecutar_idu($sql);
    }

    public function modificar()
    {
        $sql = "update clientes 
        set razon_social = '$this->razonsocial', 
            nombre_corto = '$this->nombrecomercial',
            nro_documento = '$this->nrodocumento',
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
            $this->documento = $fila['documento'];
            $this->nombre = $fila['nombre'];
            $this->direccion = $fila['direccion'];
            $this->telefono = $fila['telefono'];
            $this->celular = $fila['celular'];
            $this->venta = $fila['venta'];
            $this->pago = $fila['pago'];
            $this->ultimaventa = $fila['ultima_venta'];
        }
    }

    public function verFilas()
    {
        $sql = "select * from clientes 
                where id_cliente = '$this->idcliente' ";
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