<?php

include 'cl_conectar.php';

class cl_empleado {

    private $codigo;
    private $dni;
    private $nombres;
    private $paterno;
    private $materno;
    private $direccion;
    private $fecha_nacimiento;
    private $estado_civil;
    private $telefono;
    private $celular;
    private $email;
    private $grado;
    private $profesion;
    private $cargo;
    private $categoria;
    private $jornal;
    private $imagen;
    private $curriculum;
    private $archivo_dni;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getDni() {
        return $this->dni;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getPaterno() {
        return $this->paterno;
    }

    function getMaterno() {
        return $this->materno;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getFecha_nacimiento() {
        return $this->fecha_nacimiento;
    }

    function getEstado_civil() {
        return $this->estado_civil;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getEmail() {
        return $this->email;
    }

    function getGrado() {
        return $this->grado;
    }

    function getProfesion() {
        return $this->profesion;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getJornal() {
        return $this->jornal;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setNombres($nombres) {
        $this->nombres = trim(strtoupper($nombres));
    }

    function setPaterno($paterno) {
        $this->paterno = trim(strtoupper($paterno));
    }

    function setMaterno($materno) {
        $this->materno = trim(strtoupper($materno));
    }

    function setDireccion($direccion) {
        $this->direccion = trim(strtoupper($direccion));
    }

    function setFecha_nacimiento($fecha_nacimiento) {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    function setEstado_civil($estado_civil) {
        $this->estado_civil = $estado_civil;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setGrado($grado) {
        $this->grado = $grado;
    }

    function setProfesion($profesion) {
        $this->profesion = $profesion;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setJornal($jornal) {
        $this->jornal = $jornal;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function getCurriculum() {
        return $this->curriculum;
    }

    function getArchivo_dni() {
        return $this->archivo_dni;
    }

    function setCurriculum($curriculum) {
        $this->curriculum = $curriculum;
    }

    function setArchivo_dni($archivo_dni) {
        $this->archivo_dni = $archivo_dni;
    }

    function i_empleado() {
        $grabado = false;
        global $conn;
        $query = "insert into colaborador values ('" . $this->codigo . "', '" . $this->dni . "', '" . $this->nombres . "', '" . $this->paterno . "', '" . $this->materno . "', "
                . "'" . $this->direccion . "' , '" . $this->email . "', '" . $this->fecha_nacimiento . "', '" . $this->telefono . "', '" . $this->celular . "', '" . $this->grado . "', "
                . "'" . $this->profesion . "', '" . $this->cargo . "', '" . $this->categoria . "', '" . $this->jornal . "', '" . $this->estado_civil . "', '" . $this->imagen . "', "
                . "'" . $this->curriculum . "', '" . $this->archivo_dni . "','1')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in clientes: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function modificar() {
        $grabado = false;
        global $conn;
        $query = "update colaborador set nombres = '" . $this->nombres . "', ape_pat = '" . $this->paterno . "', ape_mat = '" . $this->materno . "', direccion = "
                . "'" . $this->direccion . "' , email = '" . $this->email . "', fecha_nacimiento = '" . $this->fecha_nacimiento . "', telefono1 = '" . $this->telefono . "', telefono2 = '" . $this->celular . "', "
                . "grado_estudios = '" . $this->grado . "', profesion = '" . $this->profesion . "', cargo = '" . $this->cargo . "', categoria = '" . $this->categoria . "', jornal_dia = '" . $this->jornal . "', "
                . "estado_civil = '" . $this->estado_civil . "', imagen = '" . $this->imagen . "' where id = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not update data in clientes: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function v_tabla_empleados() {
        global $conn;
        $query = "select c.id, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, c.fecha_nacimiento, c.jornal_dia, cat.descripcion as categoria, civ.descripcion as estado_civil, car.descripcion as cargo "
                . "from colaborador as c "
                . "inner join detalle_tabla_general as cat on cat.general = '4' and cat.id = c.categoria "
                . "inner join detalle_tabla_general as civ on civ.general = '3' and civ.id = c.estado_civil "
                . "inner join detalle_tabla_general as car on car.general = '1' and car.id = c.cargo ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function v_tabla_empleados_epp() {
        global $conn;
        $query = "select c.id, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, c.fecha_nacimiento, c.jornal_dia, cat.descripcion as categoria, civ.descripcion as estado_civil, car.descripcion as cargo "
                . "from colaborador as c "
                . "inner join detalle_tabla_general as cat on cat.general = '4' and cat.id = c.categoria "
                . "inner join detalle_tabla_general as civ on civ.general = '3' and civ.id = c.estado_civil "
                . "inner join detalle_tabla_general as car on car.general = '1' and car.id = c.cargo "
                . "inner join entrega_epp as ee on ee.colaborador = c.id "
                . "where ee.estado = 0 "
                . "group by c.id";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function v_cumpleanos_mes() {
        global $conn;
        $query = "select c.id, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, day(c.fecha_nacimiento) as dia, month(c.fecha_nacimiento) as mes, year(c.fecha_nacimiento) as anio,  (year(now()) - year(c.fecha_nacimiento)) AS edad "
                . "from colaborador as c "
                . "where month(c.fecha_nacimiento) = month (now()) and day(c.fecha_nacimiento) >= day (now()) "
                . "order by day(c.fecha_nacimiento) asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(id) + 1, 1) as codigo from colaborador ";
        $r_codigo = $conn->query($c_codigo);
        if ($r_codigo->num_rows > 0) {
            while ($fila = $r_codigo->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function buscar_dni() {
        $existe = false;
        global $conn;
        $consulta = "select count(*) as cantidad from colaborador where dni = '" . $this->dni . "'";
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

    function obtener_datos() {
        $existe = false;
        global $conn;
        $consulta = "select * from colaborador where id = '" . $this->codigo . "'";
        $respuesta = $conn->query($consulta);
        if ($respuesta->num_rows > 0) {
            while ($fila = $respuesta->fetch_assoc()) {
                $existe = true;
                $this->nombres = $fila['nombres'];
                $this->paterno = $fila['ape_pat'];
                $this->materno = $fila['ape_mat'];
                $this->direccion = $fila['direccion'];
                $this->dni = $fila['dni'];
                $this->materno = $fila['ape_mat'];
                $this->email = $fila['email'];
                $this->telefono = $fila['telefono1'];
                $this->fecha_nacimiento = $fila['fecha_nacimiento'];
                $this->grado = $fila['grado_estudios'];
                $this->jornal = $fila['jornal_dia'];
                $this->cargo = $fila['cargo'];
                $this->profesion = $fila['profesion'];
                $this->categoria = $fila['categoria'];
                $this->estado_civil = $fila['estado_civil'];
                $this->imagen = $fila['imagen'];
            }
        }
        return $existe;
    }

}
