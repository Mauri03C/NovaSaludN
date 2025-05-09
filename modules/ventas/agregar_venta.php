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

    // Validar datos
    if (!is_numeric($id_producto) || !is_numeric($cantidad) || $cantidad <= 0) {
        die("Datos inválidos.");
    }

    // Obtener el precio del producto con consulta segura
    $stmt = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    if (!$producto) {
        die("Producto no encontrado.");
    }

    $precio = $producto['precio'];
    $total = $cantidad * $precio;

    // Insertar la venta con consulta preparada
    $stmt = $conn->prepare("INSERT INTO ventas (id_producto, cantidad, total) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $id_producto, $cantidad, $total);
    $stmt->execute();

    header("Location: ventas.php");
    exit();
}

// Cargar productos
$productos = $conn->query("SELECT * FROM productos");
?>

<?php include '../../includes/header.php'; ?>

<div class="container mt-5">
    <h3>Registrar Venta</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="id_producto" class="form-label">Producto</label>
            <select name="id_producto" id="id_producto" class="form-select" required>
                <option value="">Seleccione un producto</option>
                <?php while ($producto = $productos->fetch_assoc()) : ?>
                    <option value="<?= htmlspecialchars($producto['id']) ?>"><?= htmlspecialchars($producto['nombre']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Venta</button>
        <a href="ventas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
