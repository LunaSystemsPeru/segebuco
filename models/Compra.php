<?php
require_once 'Conectar.php';

class Compra
{
    private $id;
    private $fecha;
    private $documento_serie;
    private $documento_numero;
    private $proveedor_id;
    private $usuario_id;
    private $porcentaje_igv;
    private $base_exonerado;
    private $base_igv;
    private $moneda_id;
    private $tipo_cambio;
    private $tipo_compra_id;
    private $conectar;

    /**
     * Compra constructor.
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getDocumentoSerie()
    {
        return $this->documento_serie;
    }

    /**
     * @param mixed $documento_serie
     */
    public function setDocumentoSerie($documento_serie): void
    {
        $this->documento_serie = $documento_serie;
    }

    /**
     * @return mixed
     */
    public function getDocumentoNumero()
    {
        return $this->documento_numero;
    }

    /**
     * @param mixed $documento_numero
     */
    public function setDocumentoNumero($documento_numero): void
    {
        $this->documento_numero = $documento_numero;
    }

    /**
     * @return mixed
     */
    public function getProveedorId()
    {
        return $this->proveedor_id;
    }

    /**
     * @param mixed $proveedor_id
     */
    public function setProveedorId($proveedor_id): void
    {
        $this->proveedor_id = $proveedor_id;
    }

    /**
     * @return mixed
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    /**
     * @param mixed $usuario_id
     */
    public function setUsuarioId($usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    /**
     * @return mixed
     */
    public function getPorcentajeIgv()
    {
        return $this->porcentaje_igv;
    }

    /**
     * @param mixed $porcentaje_igv
     */
    public function setPorcentajeIgv($porcentaje_igv): void
    {
        $this->porcentaje_igv = $porcentaje_igv;
    }

    /**
     * @return mixed
     */
    public function getBaseExonerado()
    {
        return $this->base_exonerado;
    }

    /**
     * @param mixed $base_exonerado
     */
    public function setBaseExonerado($base_exonerado): void
    {
        $this->base_exonerado = $base_exonerado;
    }

    /**
     * @return mixed
     */
    public function getBaseIgv()
    {
        return $this->base_igv;
    }

    /**
     * @param mixed $base_igv
     */
    public function setBaseIgv($base_igv): void
    {
        $this->base_igv = $base_igv;
    }

    /**
     * @return mixed
     */
    public function getMonedaId()
    {
        return $this->moneda_id;
    }

    /**
     * @param mixed $moneda_id
     */
    public function setMonedaId($moneda_id): void
    {
        $this->moneda_id = $moneda_id;
    }

    /**
     * @return mixed
     */
    public function getTipoCambio()
    {
        return $this->tipo_cambio;
    }

    /**
     * @param mixed $tipo_cambio
     */
    public function setTipoCambio($tipo_cambio): void
    {
        $this->tipo_cambio = $tipo_cambio;
    }

    /**
     * @return mixed
     */
    public function getTipoCompraId()
    {
        return $this->tipo_compra_id;
    }

    /**
     * @param mixed $tipo_compra_id
     */
    public function setTipoCompraId($tipo_compra_id): void
    {
        $this->tipo_compra_id = $tipo_compra_id;
    }


}