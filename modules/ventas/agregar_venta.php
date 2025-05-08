<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    
    // Obtener el precio del producto
    $producto = $conn->query("SELECT precio FROM productos WHERE id = $id_producto")->fetch_assoc();
    $precio = $producto['precio'];
    
    $total = $cantidad * $precio;
    
    // Insertar la venta
    $conn->query("INSERT INTO ventas (id_producto, cantidad, total) VALUES ($id_producto, $cantidad, $total)");

    header("Location: ventas.php");
}

$productos = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Venta - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Registrar Venta</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="id_producto" class="form-label">Producto</label>
            <select name="id_producto" class="form-select" required>
                <option value="">Seleccione un producto</option>
                <?php while ($producto = $productos->fetch_assoc()) : ?>
                    <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                <?php endwhile ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>
</div>
</body>
</html>
