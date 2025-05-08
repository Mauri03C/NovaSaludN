<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Agregar Nuevo Producto</h3>
    <form action="guardar_producto.php" method="POST">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio (S/)</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <input type="text" name="categoria" class="form-control">
        </div>
        <div class="mb-3">
            <label>Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
