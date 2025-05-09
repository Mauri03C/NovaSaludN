<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Validar el rol (si es necesario)
if ($_SESSION['rol'] !== 'admin') {
    // Redirigir a una página de error o a una página de acceso restringido
    header("Location: acceso_restringido.php");
    exit();
}
?>

<?php include('includes/header.php'); ?>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Usar htmlspecialchars para evitar XSS -->
        <span class="navbar-brand">Nova Salud - Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></span>
        <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
    </div>
</nav>

<div class="container mt-5">
    <h3>Panel Principal</h3>
    <p>Aquí puedes acceder a inventario, ventas y atención al cliente.</p>
    <!-- Agregar enlaces o botones para diferentes secciones -->
    <div class="row">
        <div class="col-4">
            <a href="inventario.php" class="btn btn-primary w-100">Inventario</a>
        </div>
        <div class="col-4">
            <a href="ventas.php" class="btn btn-primary w-100">Ventas</a>
        </div>
        <div class="col-4">
            <a href="atencion.php" class="btn btn-primary w-100">Atención al Cliente</a>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
