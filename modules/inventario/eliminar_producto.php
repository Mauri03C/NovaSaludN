<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Primero, verificar si el producto existe
    $verificar = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $verificar->bind_param("i", $id);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: inventario.php?mensaje=producto_eliminado");
            exit();
        } else {
            echo "Error al eliminar el producto: " . $stmt->error;
        }
    } else {
        echo "Producto no encontrado.";
    }
} else {
    echo "ID de producto no especificado.";
}
?>
