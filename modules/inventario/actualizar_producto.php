<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $stmt = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, stock=?, precio=?, categoria=?, fecha_vencimiento=? WHERE id=?");
    $stmt->bind_param("sssdssi", $nombre, $descripcion, $stock, $precio, $categoria, $fecha_vencimiento, $id);

    if ($stmt->execute()) {
        header("Location: inventario.php?mensaje=producto_actualizado");
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }
}
?>
