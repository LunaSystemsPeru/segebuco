<?php
require_once 'Conectar.php';

class Usuario
{
    private $id;
    private $username;
    private $password;
    private $fec_login;
    private $colaboradorid;
    private $email;
    private $estado;
    private $conectar;

    /**
     * Usuario3 constructor.
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getFecLogin()
    {
        return $this->fec_login;
    }

    /**
     * @param mixed $fec_login
     */
    public function setFecLogin($fec_login): void
    {
        $this->fec_login = $fec_login;
    }

    /**
     * @return mixed
     */
    public function getColaboradorid()
    {
        return $this->colaboradorid;
    }

    /**
     * @param mixed $colaboradorid
     */
    public function setColaboradorid($colaboradorid): void
    {
        $this->colaboradorid = $colaboradorid;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }


    public function validarUsername()
    {
        $sql = "select id 
                from usuarios 
                where username = '$this->username'";
        return $this->id = $this->conectar->get_valor_query($sql, 'id');
    }

    function obtenerDatos(){
        $sql = "SELECT * FROM usuarios WHERE id = '$this->id'";
        $fila = $this->conectar->get_Row($sql);
        if($fila){
            $this->username = $fila['username'];
            $this->password = $fila['password'];
            $this->fec_login = $fila['fec_login'];
            $this->colaboradorid = $fila['colaboradorid'];
            $this->email = $fila['email'];
            $this->estado = $fila['estado'];
        }
    }


    function actualizarLogeo(){
        $sql = "UPDATE usuarios SET
        fec_login = 'current_timestamp()'
        WHERE id = '$this->id'";
        return $this->conectar->ejecutar_idu($sql);
    }
}