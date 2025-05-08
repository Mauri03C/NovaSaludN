<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$resultado = $conn->query("SELECT * FROM productos");

// Consulta para obtener el número de productos con stock bajo
$alerta_query = "SELECT COUNT(*) AS bajos FROM productos WHERE stock <= 5";
$alerta_result = $conn->query($alerta_query);
$alerta_data = $alerta_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo para productos con stock bajo */
        .alerta-stock {
            background-color: #ffe6e6;
            color: #b30000;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3>Gestión de Inventario</h3>
    
    <!-- Mostrar alerta si hay productos con stock bajo -->
    <?php if ($alerta_data['bajos'] > 0): ?>
        <div class="alert alert-danger">
            <strong>¡Atención!</strong> Hay <?= $alerta_data['bajos'] ?> producto(s) con stock bajo.
        </div>
    <?php endif; ?>
    
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
                <tr class="<?= $fila['stock'] <= 5 ? 'alerta-stock' : '' ?>"> <!-- Agregar la clase si el stock es bajo -->
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
