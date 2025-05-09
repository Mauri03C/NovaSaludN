<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    // Validación básica
    if ($nombre === "") {
        $mensaje = "El nombre es obligatorio.";
    } else {
        // Validación de correo electrónico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $mensaje = "El correo electrónico no es válido.";
        } elseif (!preg_match("/^[0-9]{10}$/", $telefono)) {
            // Validación simple de teléfono (asegúrate de que tenga 10 dígitos numéricos)
            $mensaje = "El teléfono debe tener 10 dígitos.";
        } else {
            // Preparar la consulta para agregar el cliente
            $stmt = $conn->prepare("INSERT INTO clientes (nombre, correo, telefono) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $correo, $telefono);

            if ($stmt->execute()) {
                $mensaje = "Cliente agregado correctamente.";
            } else {
                $mensaje = "Error al agregar cliente. Intenta nuevamente.";
            }
        }
    }
}
?>

<?php include('../../includes/header.php'); ?>

<body>
<div class="container mt-5">
    <h3>Agregar Nuevo Cliente</h3>
    <a href="clientes.php" class="btn btn-secondary mb-3">Volver a la lista</a>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo *</label>
            <input type="text" class="form-control" name="nombre" id="nombre" required value="<?= htmlspecialchars($nombre ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" name="correo" id="correo" value="<?= htmlspecialchars($correo ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="telefono" id="telefono" value="<?= htmlspecialchars($telefono ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-success">Guardar Cliente</button>
    </form>
</div>

<?php include('../../includes/footer.php'); ?>

</body>
</html>
