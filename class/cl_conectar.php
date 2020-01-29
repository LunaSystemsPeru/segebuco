<?php

$servidor = "localhost";
$bd = "segebuco";
$usu = "root_lsp";
$pass = "root/*123";
$puerto = "3306";
$conn = new mysqli($servidor, $usu, $pass, $bd, $puerto);
mysqli_set_charset($conn, "utf8");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
