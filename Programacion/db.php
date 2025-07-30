<?php
//(esto es solo para pruebas por ahora)//
$host = "localhost";
$user = "root";
$pass = "";
$db = "cooperativa";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>