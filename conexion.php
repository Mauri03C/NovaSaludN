<?php
// Parámetros de conexión a la base de datos
$dsn = "mysql:host=localhost;dbname=NovaSalud;charset=utf8";
$usuario = "root";
$contrasena = "";

try {
    // Crear la conexión usando PDO
    $conexion = new PDO($dsn, $usuario, $contrasena);
    // Configurar el modo de error para que lance excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    // Si hay un error en la conexión, se detiene la ejecución y se muestra el mensaje
    die("Error: " . $e->getMessage());
}
?>
