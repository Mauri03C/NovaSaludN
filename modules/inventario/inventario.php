<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$resultado = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Gestión de Inventario</h3>
    <a href="agregar_producto.php" class="btn btn-primary mb-3">Agregar Producto</a>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= $fila['stock'] ?></td>
                    <td>S/ <?= number_format($fila['precio'], 2) ?></td>
                    <td><?= $fila['fecha_vencimiento'] ?></td>
                    <td>
                        <a href="editar_producto.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminar_producto.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>
</body>
</html>
