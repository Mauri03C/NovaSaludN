<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

// Utilizando consultas preparadas
$stmt = $conn->prepare("SELECT ventas.id, productos.nombre, ventas.cantidad, ventas.total, ventas.fecha_venta 
                        FROM ventas 
                        JOIN productos ON ventas.id_producto = productos.id");
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Lista de Ventas</h3>
    <a href="agregar_venta.php" class="btn btn-primary mb-3">Registrar Venta</a>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($venta = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?= $venta['id'] ?></td>
                    <td><?= htmlspecialchars($venta['nombre']) ?></td>
                    <td><?= $venta['cantidad'] ?></td>
                    <td>S/ <?= number_format($venta['total'], 2) ?></td>
                    <td><?= $venta['fecha_venta'] ?></td>
                    <td>
                        <a href="detalle_venta.php?id=<?= $venta['id'] ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                        <a href="eliminar_venta.php?id=<?= $venta['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta venta?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>
</body>
</html>
