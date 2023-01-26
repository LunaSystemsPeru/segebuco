<?php
require_once 'Conectar.php';

class Cotizacion
{
    private $id;
    private $nro;
    private $feccotizacion;
    private $idusuario;
    private $estado;
    private $fecregistro;
    private $idmoneda;
    private $moncotizacion;
    private $monaprobado;
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
     * @param mixed  $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFecregistro()
    {
        return $this->fecregistro;
    }

    /**
     * @param mixed $fecregistro
     */
    public function setFecregistro($fecregistro)
    {
        $this->fecregistro = $fecregistro;
    }

    /**
     * @return mixed
     */
    public function getFeccotizacion()
    {
        return $this->feccotizacion;
    }

    /**
     * @param mixed $feccotizacion
     */
    public function setFeccotizacion($feccotizacion)
    {
        $this->feccotizacion = $feccotizacion;
    }

    /**
     * @return mixed
     */
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * @param mixed $nro
     */
    public function setNro($nro)
    {
        $this->nro = $nro;
    }

    /**
     * @return mixed
     */
    public function getIdusuario()
    {
        return $this->idusuario;;
    }

    /**
     * @param mixed $idusuario
     */
    public function setIdcotizacion($idusuario)
    {
        $this->idusuario = $idusuario;
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
    public function getIdmoneda()
    {
        return $this->idmoneda;
    }

    /**
     * @param mixed $idmoneda
     */
    public function setIdmoneda($idmoneda)
    {
        $this->idmoneda = $idmoneda;
    }

    /**
     * @return mixed
     */
    public function getMoncotizacion()
    {
        return $this->moncotizacion;
    }

    /**
     * @param mixed $moncotizacion
     */
    public function setMoncotizacion($moncotizacion)
    {
        $this->moncotizacion = $moncotizacion;
    }
    /**
     * @return mixed
     */
    public function getMonaprobado()
    {
        return $this->monaprobado;
    }

    /**
     * @param mixed $monaprobado
     */
    public function setMonaprobado($monaprobado)
    {
        $this->monaprobado = $monaprobado;
    }

    function obtenerId()
    {
        $sql = "SELECT IFNULL(MAX(id) + 1, 1) AS codigo FROM cotizaciones";
        return $this->id = $this->conectar->get_valor_query($sql, 'codigo');
    }

    function insertar()
    {
        $sql = "INSERT INTO cotizaciones VALUE(
            '$this->id',
            '$this->nro',
            '$this->feccotizacion',
            '$this->idusuario',
            '$this->estado',
            '$this->fecregistro',
            '$this->idmoneda',
            '$this->moncotizacion',
            '$this->monaprobado'
        )";
        return $this->conectar->ejecutar_idu($sql);
    }

    function modificar()
    {
        $sql = "UPDATE cotizaciones SET
            nro = '$this->nro',
            fecha_cotizacion = '$this->feccotizacion',
            usuarioid = '$this->idusuario',
            estado = '$this->estado',
            fecha_registro = '$this->fecregistro',
            monedaid = '$this->idmoneda',
            monto_cotizacion = '$this->moncotizacion',
            monto_aprobado = '$this->monaprobado'
            WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }

    function obtenerDatos()
    {
        $sql = "SELECT * FROM cotizaciones WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if ($fila) {
            $this->id = $fila['id'];
            $this->nro = $fila['nro'];
            $this->feccotizacion = $fila['fecha_cotizacion'];
            $this->idusuario = $fila['usuarioid'];
            $this->estado = $fila['estado'];
            $this->fecregistro = $fila['nfecha_registroro'];
            $this->idmoneda = $fila['monedaid'];
            $this->moncotizacion = $fila['monto_cotizacion'];
            $this->monaprobado = $fila['monto_aprobado'];
        }
    }

    function verFilas()
    {
        $sql = "SELECT * FROM cotizaciones";
        return $this->conectar->get_Cursor($sql);
    }
}
