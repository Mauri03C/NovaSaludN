<?php
session_start();
require_once 'includes/db.php';

// Validar que el formulario tenga los datos necesarios
if (!isset($_POST['usuario'], $_POST['password'])) {
    header("Location: login.php"); // Redirigir si faltan datos
    exit();
}

$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Preparar la consulta SQL
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si el usuario existe y la contraseña es correcta
if ($result->num_rows === 1) {
    $fila = $result->fetch_assoc();
    if (password_verify($password, $fila['password'])) {
        // Iniciar sesión y redirigir al dashboard
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['rol'] = $fila['rol'];
        header("Location: dashboard.php");
        exit();
    }
}

// Si la autenticación falla, redirigir con un mensaje de error
$_SESSION['error'] = "Usuario o contraseña incorrectos";
header("Location: login.php");
exit();
