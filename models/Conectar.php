<?php


/**
 * Created by PhpStorm.
 * User: ANDY
 * Date: 02/05/2019
 * Time: 06:42 PM
 */
class conectar
{

    private static $_instancia;
    private $_connection;
    private $_link;
    // private $_host = "localhost";
    private $_host = "localhost";
    private $_user = "goempres_root";
    private $_pass = "k;6?6,m{7ePs";
    // Almacenar una unica instancia
    private $_db = "goempres_segebuco_app";

    //mysqldump -h artemisa.servidoresph.com -u brunoasc_luis_bd -p brunoasc_casabiblia_new > goempres_casabiblia.sql   C]6&TN4Bt@&I

    /**
     * constructor de la clase Base de datos
     */
    public function __construct()
    {
        date_default_timezone_set('America/Lima');

        $this->_connection = new mysqli($this->_host, $this->_user, $this->_pass, $this->_db);
        $this->_link = mysqli_connect($this->_host, $this->_user, $this->_pass, $this->_db) or die('Could not connect to database!');
        // Manejar error en base de datos
        if (mysqli_connect_error()) {
            trigger_error('Falla en la conexion de base de datos' . mysqli_connect_error(), E_USER_ERROR);
        }
        $this->_connection->query("SET NAMES 'utf8'");
    }

    /**
     * @return false|mysqli
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     *  Funcion que ejecuta el SQL y retorna un ROW
     *        Esta funcion esta pensada para SQLs,
     *        que retornen unicamente UNA sola línea
     */
    public function get_Row($sql)
    {

        if (!self::es_string($sql))
            exit();
        $db = conectar::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        if ($row = $resultado->fetch_assoc()) {
            return $row;
        } else {
            return array();
        }
    }

    /**
     *  Metodo que revisa el String SQL
     */
    private function es_string($sql)
    {
        if (!is_string($sql)) {
            trigger_error('class.conectar.inc: $SQL enviado no es un string: ' . $sql);
            return false;
        }
        return true;
    }

    /**
     * getInstancia Metodo para obtener instancia de base de datos.
     */
    public static function getInstancia()
    {
        if (!isset(self::$_instancia)) {
            self::$_instancia = new self;
        }
        return self::$_instancia;
    }

    /**
     * Metodo para obtener la conexion a la base de datos
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * Funcion que ejecuta el SQL y retorna un CURSOR
     *        Esta funcion esta pensada para SQLs,
     *        que retornen multiples lineas (1 o varias)
     */
    public function get_Cursor($sql)
    {
        if (!self::es_string($sql))
            exit();
        $db = conectar::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        return $resultado; // Este resultado se puede usar así:  while ($row = $resultado->fetch_assoc()){...}
    }

    /**
     * @param $sql
     * @return json
     * Funcion que ejecuta el SQL y retorna un jSon
     * data: [{...}] con N cantidad de registros
     */
    public function get_json_rows($sql)
    {
        if (!self::es_string($sql))
            exit();
        $db = conectar::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        // Si hay un error en el SQL, este es el error de MySQL
        if (!$resultado) {
            return "class.conectar.class: error " . $mysqli->error;
        }

        $i = 0;
        $registros = array();
        while ($row = $resultado->fetch_assoc()) {
            $registros[$i] = $row;
            $i++;
        };
        return json_encode($registros);
    }

    /**
     * @param $sql
     * @return json
     * Funcion que ejecuta el SQL y retorna un jSon
     * de una sola linea. Ideal para imprimir un
     * Query que solo retorne una linea
     */
    public function get_json_row($sql)
    {
        if (!self::es_string($sql))
            exit();
        $db = conectar::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        // Si hay un error en el SQL, este es el error de MySQL
        if (!$resultado) {
            return "class.conectar.class: error " . $mysqli->error;
        }
        if (!$row = $resultado->fetch_assoc()) {
            return "{}";
        }
        return json_encode($row);
    }

    /**
     * @param $sql
     * @param $columna
     * @return valor de celda
     * Funcion que ejecuta el SQL y retorna un valor
     * Ideal para count(*), Sum, cosas que retornen una fila y una columna
     */
    public function get_valor_query($sql, $columna)
    {
        if (!self::es_string($sql, $columna))
            exit();
        $db = conectar::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        // Si hay un error en el SQL, este es el error de MySQL
        if (!$resultado) {
            return "class.conectar.class: error " . $mysqli->error;
        }
        $Valor = NULL;
        //Trae el primer valor del arreglo
        if ($row = $resultado->fetch_assoc()) {
            // $Valor = array_values($row)[0];
            $Valor = $row[$columna];
        }
        return $Valor;
    }

    /**
     * @param $sql
     * @return boolean
     * Funcion que ejecuta el SQL de inserción, actualización y eliminación
     */
    public function ejecutar_idu($sql)
    {
        if (!self::es_string($sql))
            exit();
        $db = conectar::getInstancia();
        $mysqli = $db->getConnection();
        if (!$resultado = $mysqli->query($sql)) {
            echo "class.conectar.class: error " . $mysqli->error . " con " . $sql . "<br>";
            return false;
        } else {
            return $resultado;
        }

        return $resultado;
    }

    /**
     * @param $aEncryptar
     * @param int $digito
     * @return string
     * Funciones para encryptar y desencryptar data:
     * crypt_blowfish_bydinvaders
     */
    function crypt($aEncryptar, $digito = 7)
    {
        $set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $salt = sprintf('$2a$%02d$', $digito);
        for ($i = 0; $i < 22; $i++) {
            $salt .= $set_salt[mt_rand(0, 22)];
        }
        return crypt($aEncryptar, $salt);
    }

    function uncrypt($Evaluar, $Contra)
    {
        if (crypt($Evaluar, $Contra) == $Contra)
            return true;
        else
            return false;
    }

    /**
     * Metodo vacio __close para evitar duplicacion
     */
    private function __close()
    {

    }

}
