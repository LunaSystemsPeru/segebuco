<?php

include 'cl_conectar.php';

class cl_entidad
{

    private $ruc;
    private $razon_social;
    private $direccion;
    private $nombre_comercial;
    private $condicion;
    private $estado;

    function __construct()
    {

    }

    function getRuc()
    {
        return $this->ruc;
    }

    function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    function getRazon_social()
    {
        return $this->razon_social;
    }

    function setRazon_social($razon_social)
    {
        $this->razon_social = $razon_social;
    }

    function getDireccion()
    {
        return $this->direccion;
    }

    function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    function getNombre_comercial()
    {
        return $this->nombre_comercial;
    }

    function setNombre_comercial($nombre_comercial)
    {
        $this->nombre_comercial = $nombre_comercial;
    }

    function getCondicion()
    {
        return $this->condicion;
    }

    function setCondicion($condicion)
    {
        $this->condicion = $condicion;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function setEstado($estado)
    {
        $this->estado = $estado;
    }

    function i_entidad()
    {
        $grabado = false;
        global $conn;
        $query = "insert into entidad values ('" . $this->ruc . "', '" . $this->razon_social . "', '" . $this->nombre_comercial . "', '" . $this->direccion . "', '" . $this->condicion . "', "
            . "'" . $this->estado . "')";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in ENTIDAD: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function m_entidad()
    {
        $grabado = false;
        global $conn;
        $query = "update entidad "
            . "set razon_social = '" . $this->razon_social . "', nombre_comercial =  '" . $this->nombre_comercial . "', direccion = '" . $this->direccion . "', condicion = '" . $this->condicion . "', estado = '" . $this->estado . "' "
            . "where ruc = '" . $this->ruc . "'";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not modificy data in ENTIDAD: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_entidad()
    {
        global $conn;
        $query = "select * from entidad order by razon_social asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function buscar_ruc()
    {
        $existe = false;
        global $conn;
        $consulta = "select count(*) as cantidad from entidad where ruc = '" . $this->ruc . "'";
        $respuesta = $conn->query($consulta);
        if ($respuesta->num_rows > 0) {
            while ($fila = $respuesta->fetch_assoc()) {
                $encontrado = $fila ['cantidad'];
                if ($encontrado > 0) {
                    $existe = true;
                }
            }
        }
        return $existe;
    }

    function obtener_datos()
    {
        $existe = false;
        global $conn;
        $consulta = "select * 
        from entidad 
        where ruc = '" . $this->ruc . "'";
        $respuesta = $conn->query($consulta);
        if ($respuesta->num_rows > 0) {
            $existe = true;
            while ($fila = $respuesta->fetch_assoc()) {
                $this->razon_social = $fila['razon_social'];
                $this->nombre_comercial = $fila['nombre_comercial'];
                $this->direccion = $fila['direccion'];
                $this->condicion = $fila['condicion'];
                $this->estado = $fila['estado'];
            }
        }
        return $existe;
    }

    function datos_ruc()
    {
        global $conn;
        $consulta = "select * from entidad where ruc = '" . $this->ruc . "'";
        $respuesta = $conn->query($consulta);
        $fila = $respuesta->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
