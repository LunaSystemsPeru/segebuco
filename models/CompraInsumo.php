<?php
require_once 'Conectar.php';

class CompraInsumo
{
    private $id;
    private $compra_id;
    private $insumo_id;
    private $cantidad;
    private $costo_sigv;
    private $conectar;

    /**
     * CompraInsumo constructor.
     */
    public function __construct()
    {
        $this->conectar = Conectar::getInstancia();
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
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCompraId()
    {
        return $this->compra_id;
    }

    /**
     * @param mixed $compra_id
     */
    public function setCompraId($compra_id): void
    {
        $this->compra_id = $compra_id;
    }

    /**
     * @return mixed
     */
    public function getInsumoId()
    {
        return $this->insumo_id;
    }

    /**
     * @param mixed $insumo_id
     */
    public function setInsumoId($insumo_id): void
    {
        $this->insumo_id = $insumo_id;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getCostoSigv()
    {
        return $this->costo_sigv;
    }

    /**
     * @param mixed $costo_sigv
     */
    public function setCostoSigv($costo_sigv): void
    {
        $this->costo_sigv = $costo_sigv;
    }


}