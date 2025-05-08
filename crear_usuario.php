<?php
require_once 'includes/db.php';

$usuario = "admin";
$password = password_hash("123456", PASSWORD_DEFAULT);
$rol = "admin";

$sql = "INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $usuario, $password, $rol);

if ($stmt->execute()) {
    echo "Usuario creado con éxito.";
} else {
    echo "Error: " . $stmt->error;
}
?>
