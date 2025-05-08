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
$venta = $conn->query("SELECT * FROM ventas WHERE id = $id_venta")->fetch_assoc();
if (!$venta) {
    echo "Venta no encontrada.";
    exit();
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Obtener nuevo precio
    $producto = $conn->query("SELECT precio FROM productos WHERE id = $id_producto")->fetch_assoc();
    $precio = $producto['precio'];
    $total = $cantidad * $precio;

    // Actualizar venta
    $conn->query("UPDATE ventas SET id_producto = $id_producto, cantidad = $cantidad, total = $total WHERE id = $id_venta");

    header("Location: ventas.php");
    exit();
}

// Obtener todos los productos
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
                <?php while ($producto = $productos->fetch_assoc()) : ?>
                    <option value="<?= $producto['id'] ?>" <?= $producto['id'] == $venta['id_producto'] ? 'selected' : '' ?>>
                        <?= $producto['nombre'] ?>
                    </option>
                <?php endwhile ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $venta['cantidad'] ?>" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="ventas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
