<?php
// conexion.php
$host = "sql303.infinityfree.com";
$usuario = "if0_40977702"; // Cambia esto por tu usuario de cPanel
$password = "CYuEKdBQSWEU3bq";    // Cambia esto por tu contraseña de base de datos
$base_datos = "if0_40977702_music"; // El nombre de tu base de datos

$conn = new mysqli($host, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Esto permite que los acentos y ñ se vean bien
$conn->set_charset("utf8");
?>