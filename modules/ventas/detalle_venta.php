<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de venta inválido.");
}

$id_venta = (int) $_GET['id']; // cast seguro

// Consulta segura con prepared statement
$stmt = $conn->prepare("SELECT ventas.id, productos.nombre, ventas.cantidad, ventas.total, ventas.fecha_venta 
                        FROM ventas 
                        JOIN productos ON ventas.id_producto = productos.id
                        WHERE ventas.id = ?");
$stmt->bind_param("i", $id_venta);
$stmt->execute();
$resultado = $stmt->get_result();
$venta = $resultado->fetch_assoc();

if (!$venta) {
    die("Venta no encontrada.");
}
?>

<?php include '../../includes/header.php'; ?>

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

<?php include '../../includes/footer.php'; ?>
