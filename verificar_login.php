<?php
session_start();
require_once 'includes/db.php';

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $fila = $result->fetch_assoc();
    if (password_verify($password, $fila['password'])) {
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['rol'] = $fila['rol'];
        header("Location: dashboard.php");
        exit();
    }
}

echo "<script>alert('Usuario o contraseña incorrectos'); window.location='login.php';</script>";
