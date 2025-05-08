<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$id = $_GET['id'];
$resultado = $conn->query("SELECT * FROM productos WHERE id = $id");
$producto = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Editar Producto</h3>
    <form action="actualizar_producto.php" method="POST">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <input type="text" name="categoria" class="form-control" value="<?= htmlspecialchars($producto['categoria']) ?>">
        </div>
        <div class="mb-3">
            <label>Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control" value="<?= $producto['fecha_vencimiento'] ?>">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
