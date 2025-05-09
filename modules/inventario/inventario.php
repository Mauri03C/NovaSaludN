<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

require_once '../../includes/header.php'; // INCLUIR HEADER

$resultado = $conn->query("SELECT * FROM productos");

// Consulta para obtener el número de productos con stock bajo
$alerta_query = "SELECT COUNT(*) AS bajos FROM productos WHERE stock <= 5";
$alerta_result = $conn->query($alerta_query);
$alerta_data = $alerta_result->fetch_assoc();
?>

<div class="container mt-5">
    <h3>Gestión de Inventario</h3>

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
                <tr class="<?= $fila['stock'] <= 5 ? 'alerta-stock' : '' ?>">
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

<style>
    .alerta-stock {
        background-color: #ffe6e6;
        color: #b30000;
        font-weight: bold;
    }
</style>

<?php require_once '../../includes/footer.php'; // INCLUIR FOOTER ?>
