<?php
session_start();
?>

<?php include('includes/header.php'); ?>

<body class="bg-light">

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Nova Salud</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sección de bienvenida -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4">Bienvenidos a Nova Salud</h1>
            <p class="lead">Tu salud es nuestra prioridad. Proporcionamos los mejores servicios para cuidar de ti y tu bienestar.</p>
        </div>
    </div>

    <!-- Resumen de la empresa -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>¿Quiénes somos?</h3>
            <p>En **Nova Salud** nos dedicamos a ofrecer soluciones innovadoras en el área de salud, brindando servicios médicos de calidad con un equipo altamente capacitado. Nuestro objetivo es mejorar la salud y bienestar de nuestros pacientes mediante un enfoque integral y personalizado.</p>
        </div>
        <div class="col-md-6">
            <h3>Servicios</h3>
            <ul>
                <li>Consultas médicas especializadas</li>
                <li>Atención de urgencias</li>
                <li>Exámenes de laboratorio</li>
                <li>Asesoría en salud preventiva</li>
            </ul>
        </div>
    </div>
</div>

<!-- Pie de página -->
<?php include('includes/footer.php'); ?>

</body>
</html>
