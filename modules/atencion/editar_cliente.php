<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: clientes.php");
    exit();
}

$id = $_GET['id'];
$mensaje = "";

// Obtener datos del cliente
$stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();

if (!$cliente) {
    header("Location: clientes.php");
    exit();
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $stmt = $conn->prepare("UPDATE clientes SET nombre = ?, correo = ?, telefono = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nombre, $correo, $telefono, $id);

    if ($stmt->execute()) {
        // Redirigir a la lista de clientes con mensaje de éxito
        header("Location: clientes.php?mensaje=Cliente actualizado correctamente.");
        exit();
    } else {
        $mensaje = "Error al actualizar cliente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Editar Cliente</h3>
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($cliente['correo']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($cliente['telefono']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="clientes.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
</body>
</html>
