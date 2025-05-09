<?php
require_once 'includes/db.php';

// Definir los datos de usuario (en este caso, ejemplo)
$usuario = "admin";
$password = password_hash("123456", PASSWORD_DEFAULT); // Asegúrate de usar contraseñas seguras
$rol = "admin";

// Preparar la consulta SQL
$sql = "INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $usuario, $password, $rol);

// Ejecutar la consulta y manejar el resultado
if ($stmt->execute()) {
    echo "Usuario creado con éxito.";
} else {
    // Mostrar error más seguro
    error_log("Error al crear usuario: " . $stmt->error); // Registra el error en los logs
    echo "Hubo un problema al crear el usuario. Por favor, intente más tarde.";
}
?>
