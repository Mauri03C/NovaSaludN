<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$id_venta = $_GET['id'];
$venta = $conn->query("SELECT ventas.id, productos.nombre, ventas.cantidad, ventas.total, ventas.fecha_venta 
                        FROM ventas 
                        JOIN productos ON ventas.id_producto = productos.id
                        WHERE ventas.id = $id_venta")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle Venta - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Detalle de la Venta</h3>
    <table class="table table-bordered">
        <tr>
            <th>ID de Venta</th>
            <td><?= $venta['id'] ?></td>
        </tr>
        <tr>
            <th>Producto</th>
            <td><?= htmlspecialchars($venta['nombre']) ?></td>
        </tr>
        <tr>
            <th>Cantidad</th>
            <td><?= $venta['cantidad'] ?></td>
        </tr>
        <tr>
            <th>Total</th>
            <td>S/ <?= number_format($venta['total'], 2) ?></td>
        </tr>
        <tr>
            <th>Fecha de Venta</th>
            <td><?= $venta['fecha_venta'] ?></td>
        </tr>
    </table>
    <a href="ventas.php" class="btn btn-secondary">Volver a Ventas</a>
</div>
</body>
</html>
