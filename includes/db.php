<?php
// Datos de conexión
$host = "localhost";
$usuario = "root";
$contraseña = "";
$base_datos = "nova_salud";

// Crear conexión
$conn = new mysqli($host, $usuario, $contraseña, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configurar codificación de caracteres
$conn->set_charset("utf8");
?>
