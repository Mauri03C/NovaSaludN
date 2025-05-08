<?php
require_once '../../includes/db.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ventas.php");
    exit();
}

$id_venta = $_GET['id'];

// Obtener datos actuales de la venta
$venta_actual = $conn->query("SELECT * FROM ventas WHERE id = $id_venta")->fetch_assoc();
if (!$venta_actual) {
    echo "Venta no encontrada.";
    exit();
}

$producto_anterior_id = $venta_actual['id_producto'];
$cantidad_anterior = $venta_actual['cantidad'];

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto_nuevo = $_POST['id_producto'];
    $cantidad_nueva = $_POST['cantidad'];

    // Revertir stock anterior
    $conn->query("UPDATE productos SET stock = stock + $cantidad_anterior WHERE id = $producto_anterior_id");

    // Descontar nuevo stock
    $producto_nuevo = $conn->query("SELECT precio, stock FROM productos WHERE id = $id_producto_nuevo")->fetch_assoc();
    $precio_unitario = $producto_nuevo['precio'];

    if ($producto_nuevo['stock'] < $cantidad_nueva) {
        echo "<div class='alert alert-danger'>No hay suficiente stock para completar esta venta.</div>";
    } else {
        $conn->query("UPDATE productos SET stock = stock - $cantidad_nueva WHERE id = $id_producto_nuevo");

        // Calcular nuevo total
        $total_nuevo = $cantidad_nueva * $precio_unitario;

        // Actualizar venta
        $conn->query("UPDATE ventas SET id_producto = $id_producto_nuevo, cantidad = $cantidad_nueva, total = $total_nuevo WHERE id = $id_venta");

        header("Location: ventas.php");
        exit();
    }
}

// Obtener productos
$productos = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Venta - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Editar Venta</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="id_producto" class="form-label">Producto</label>
            <select name="id_producto" class="form-select" required>
                <?php while ($prod = $productos->fetch_assoc()) : ?>
                    <option value="<?= $prod['id'] ?>" <?= $prod['id'] == $venta_actual['id_producto'] ? 'selected' : '' ?>>
                        <?= $prod['nombre'] ?>
                    </option>
                <?php endwhile ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $venta_actual['cantidad'] ?>" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="ventas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
