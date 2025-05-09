<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}
include '../../includes/header.php';
?>

<div class="container mt-5">
    <h3>Agregar Nuevo Producto</h3>
    <form action="guardar_producto.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio (S/)</label>
            <input type="number" id="precio" name="precio" class="form-control" step="0.01" min="0" required>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" id="categoria" name="categoria" class="form-control">
        </div>

        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
