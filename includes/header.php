<!-- header.php -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Salud - Panel de Administración</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<!-- Barra de navegación -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Nova Salud - Bienvenido, <?= isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado' ?></span>
        <?php if (isset($_SESSION['usuario'])): ?>
            <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
        <?php endif; ?>
    </div>
</nav>
