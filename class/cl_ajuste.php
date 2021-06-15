<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 01/07/19
 * Time: 02:04 PM
 */

include 'cl_conectar.php';

class cl_ajuste
{

    private $anio;
    private $id_ajuste;
    private $fecha;
    private $id_usuario;
    private $id_almacen;
    private $total_sistema;

    /**
     * cl_ajuste constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @param mixed $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    /**
     * @return mixed
     */
    public function getIdAjuste()
    {
        return $this->id_ajuste;
    }

    /**
     * @param mixed $id_ajuste
     */
    public function setIdAjuste($id_ajuste)
    {
        $this->id_ajuste = $id_ajuste;
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
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * @return mixed
     */
    public function getIdAlmacen()
    {
        return $this->id_almacen;
    }

    /**
     * @param mixed $id_almacen
     */
    public function setIdAlmacen($id_almacen)
    {
        $this->id_almacen = $id_almacen;
    }

    /**
     * @return mixed
     */
    public function getTotalSistema()
    {
        return $this->total_sistema;
    }

    /**
     * @param mixed $total_sistema
     */
    public function setTotalSistema($total_sistema)
    {
        $this->total_sistema = $total_sistema;
    }

    function obtener_id()
    {
        global $conn;
        $query = "select ifnull(max(id_ajuste) + 1, 1) as codigo 
        from ajuste_materiales 
        where anio = '" . $this->anio . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id_ajuste = $fila ['codigo'];
            }
        }
    }

    function obtener_datos()
    {
        global $conn;
        $query = "select * 
        from ajuste_materiales 
        where anio = '" . $this->anio . "' and id_ajuste = '".$this->id_ajuste."'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->fecha = $fila['fecha'];
                $this->id_usuario = $fila['id_usuario'];
                $this->id_almacen = $fila['id_almacen'];
                $this->total_sistema = $fila['total_sistema'];
            }
        }
    }

    function insertar()
    {
        $grabado = false;
        global $conn;
        $query = "insert into ajuste_materiales 
        values ('" . $this->id_ajuste . "', '" . $this->anio . "',  '" . $this->fecha . "', '" . $this->id_usuario . "',  '" . $this->id_almacen . "', "
            . "'" . $this->total_sistema . "')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in ajuste_materiales: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_periodos() {
        global $conn;
        $query = "select distinct(anio) as anio from ajuste_materiales order by anio asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_ajustes() {
        global $conn;
        $query = "select am.id_ajuste, am.anio, am.fecha, a.nombre as nalmacen, am.total_sistema, u.usuario, sum(dam.cencontrado) as tot_encontrado, sum(dam.csistema) as tot_sistema 
        from ajuste_materiales as am 
        inner join detalle_ajuste_materiales as dam on dam.anio = am.anio and dam.id_ajuste = am.id_ajuste
        inner join usuarios as u on am.id_usuario = u.usuario
        inner join almacen as a on a.codigo = am.id_almacen 
        group by am.anio, am.id_ajuste";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_total_sistema()
    {
        global $conn;
        $query = "select sum(cantidad) as tcantidad 
        from material_almacen 
        where almacen = '".$this->id_almacen."'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->total_sistema = $fila ['tcantidad'];
            }
        }
    }

}