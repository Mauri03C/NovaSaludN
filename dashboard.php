<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Validar el rol
if ($_SESSION['rol'] !== 'admin') {
    header("Location: acceso_restringido.php");
    exit();
}
?>

<?php include('includes/header.php'); ?>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Nova Salud - Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></span>
        <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
    </div>
</nav>

<div class="container mt-5">
    <h3>Panel Principal</h3>
    <p>Aquí puedes acceder a inventario, ventas y atención al cliente.</p>
    <div class="row">
        <div class="col-4">
            <a href="./modules/inventario/inventario.php" class="btn btn-primary w-100">Inventario</a>
        </div>
        <div class="col-4">
            <a href="./modules/ventas/ventas.php" class="btn btn-primary w-100">Ventas</a>
        </div>
        <div class="col-4">
            <a href="./modules/atencion/atencion.php" class="btn btn-primary w-100">Atención al Cliente</a>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
