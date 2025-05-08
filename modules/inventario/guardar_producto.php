<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, stock, precio, categoria, fecha_vencimiento) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdss", $nombre, $descripcion, $stock, $precio, $categoria, $fecha_vencimiento);

    if ($stmt->execute()) {
        header("Location: inventario.php?mensaje=producto_agregado");
    } else {
        echo "Error al guardar el producto: " . $stmt->error;
    }
}
?>
