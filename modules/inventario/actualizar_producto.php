<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar entrada
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $stock = intval($_POST['stock']);
    $precio = floatval($_POST['precio']);
    $categoria = trim($_POST['categoria']);
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    if ($id <= 0 || empty($nombre)) {
        header("Location: inventario.php?error=Datos inválidos");
        exit();
    }

    $stmt = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, stock=?, precio=?, categoria=?, fecha_vencimiento=? WHERE id=?");
    $stmt->bind_param("sssdssi", $nombre, $descripcion, $stock, $precio, $categoria, $fecha_vencimiento, $id);

    if ($stmt->execute()) {
        header("Location: inventario.php?mensaje=producto_actualizado");
        exit();
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }
}
?>
