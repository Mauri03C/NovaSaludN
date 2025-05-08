<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: clientes.php");
    exit();
}

$id = $_GET['id'];

// Verificamos si el cliente existe antes de eliminar
$stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: clientes.php?error=Cliente no encontrado");
    exit();
}

// Eliminamos el cliente
$stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Redirigimos con un mensaje de éxito
header("Location: clientes.php?mensaje=Cliente eliminado");
exit();
?>
