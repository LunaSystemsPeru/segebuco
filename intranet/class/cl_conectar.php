<?php

$servidor = "localhost";
$bd = "goempres_segebuco";
$usu = "goempres_root";
$pass = "k;6?6,m{7ePs";
$puerto = "3306";
$conn = new mysqli($servidor, $usu, $pass, $bd, $puerto);
mysqli_set_charset($conn, "utf8");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
