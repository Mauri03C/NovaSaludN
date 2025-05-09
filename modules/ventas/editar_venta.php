<?php
require_once '../../includes/db.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ventas.php");
    exit();
}

$id_venta = (int) $_GET['id']; // Aseguramos que el ID es un número entero

// Obtener datos actuales de la venta de forma segura
$stmt = $conn->prepare("SELECT * FROM ventas WHERE id = ?");
$stmt->bind_param("i", $id_venta);
$stmt->execute();
$venta_actual = $stmt->get_result()->fetch_assoc();

if (!$venta_actual) {
    echo "Venta no encontrada.";
    exit();
}

$producto_anterior_id = $venta_actual['id_producto'];
$cantidad_anterior = $venta_actual['cantidad'];

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto_nuevo = (int) $_POST['id_producto'];
    $cantidad_nueva = (int) $_POST['cantidad'];

    // Revertir stock anterior de manera segura
    $stmt = $conn->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad_anterior, $producto_anterior_id);
    $stmt->execute();

    // Obtener datos del producto nuevo
    $stmt = $conn->prepare("SELECT precio, stock FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_producto_nuevo);
    $stmt->execute();
    $producto_nuevo = $stmt->get_result()->fetch_assoc();

    if ($producto_nuevo['stock'] < $cantidad_nueva) {
        echo "<div class='alert alert-danger'>No hay suficiente stock para completar esta venta.</div>";
    } else {
        // Descontar stock del nuevo producto de manera segura
        $stmt = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $stmt->bind_param("ii", $cantidad_nueva, $id_producto_nuevo);
        $stmt->execute();

        // Calcular nuevo total
        $total_nuevo = $cantidad_nueva * $producto_nuevo['precio'];

        // Actualizar venta de forma segura
        $stmt = $conn->prepare("UPDATE ventas SET id_producto = ?, cantidad = ?, total = ? WHERE id = ?");
        $stmt->bind_param("iiis", $id_producto_nuevo, $cantidad_nueva, $total_nuevo, $id_venta);
        $stmt->execute();

        header("Location: ventas.php");
        exit();
    }
}

// Obtener productos de manera segura
$stmt = $conn->prepare("SELECT * FROM productos");
$stmt->execute();
$productos = $stmt->get_result();
?>

<?php include '../../includes/header.php'; ?>

<div class="container mt-5">
    <h3>Editar Venta</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="id_producto" class="form-label">Producto</label>
            <select name="id_producto" class="form-select" required>
                <?php while ($prod = $productos->fetch_assoc()) : ?>
                    <option value="<?= $prod['id'] ?>" <?= $prod['id'] == $venta_actual['id_producto'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prod['nombre']) ?>
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

<?php include '../../includes/footer.php'; ?>
