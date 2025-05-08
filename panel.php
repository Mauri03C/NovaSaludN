<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Inicializar variables
$ventas_totales = 0;
$recetas_atendidas = 0;
$pacientes_totales = 0;
$productos_bajo_stock = 0;

// Consultar las ventas totales
$query_ventas = "SELECT SUM(monto) as total FROM ventas";
$stmt = $conexion->query($query_ventas);
$ventas_totales = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Consultar la cantidad de recetas atendidas
$query_recetas = "SELECT COUNT(*) as total FROM recetas WHERE atendida = 1";
$stmt = $conexion->query($query_recetas);
$recetas_atendidas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Consultar la cantidad de pacientes registrados
$query_pacientes = "SELECT COUNT(*) as total FROM pacientes";
$stmt = $conexion->query($query_pacientes);
$pacientes_totales = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Consultar productos con bajo stock
$query_stock = "SELECT COUNT(*) as total FROM productos WHERE stock < 10";
$stmt = $conexion->query($query_stock);
$productos_bajo_stock = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nova Salud - Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css" />
  <script defer src="scripts.js"></script>
</head>
<body>
  <!-- Navbar -->
  <header class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
    <a class="navbar-brand" href="#">Nova Salud</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="panel.php">Panel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inventario.php">Inventario</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ventas.php">Ventas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pacientes.php">Clientes</a>
        </li>
      </ul>
      <span class="navbar-text me-3">Usuario: NS</span>
      <button class="btn btn-outline-light" onclick="logout()">Cerrar sesión</button>
    </div>
  </header>

  <main class="container py-4">
    <h1 class="mb-3">Panel Principal</h1>
    <p class="mb-4">Bienvenido al sistema de gestión de Botica "Nova Salud". Aquí tiene una visión general de su negocio.</p>

    <div class="btn-group mb-4" role="group">
      <button class="btn btn-outline-primary">Hoy</button>
      <button class="btn btn-outline-primary">Esta Semana</button>
      <button class="btn btn-primary">Este Mes</button>
    </div>

    <section class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="card text-white bg-success h-100">
          <div class="card-body">
            <h5 class="card-title">Ventas Totales</h5>
            <p class="card-text">S/ <?php echo number_format($ventas_totales, 2); ?></p>
            <small>↑ 12.5% desde el mes pasado</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-info h-100">
          <div class="card-body">
            <h5 class="card-title">Recetas Atendidas</h5>
            <p class="card-text"><?php echo $recetas_atendidas; ?></p>
            <small>↑ 8.3% desde el mes pasado</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-primary h-100">
          <div class="card-body">
            <h5 class="card-title">Pacientes Totales</h5>
            <p class="card-text"><?php echo $pacientes_totales; ?></p>
            <small>↑ 15% desde el mes pasado</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger h-100">
          <div class="card-body">
            <h5 class="card-title">Productos Bajo Stock</h5>
            <p class="card-text"><?php echo $productos_bajo_stock; ?></p>
            <small>↓ 5.2% desde el mes pasado</small>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-4">
      <h4>Actividad Reciente</h4>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Nueva venta registrada:
          <span>2x Mascarillas KN95, 1x Alcohol en Gel <br><small>25 abr. 2023</small> - S/ 47.70</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Nueva venta registrada:
          <span>2x Paracetamol 500mg, 1x Termómetro <br><small>24 abr. 2023</small> - S/ 35.90</span>
        </li>
      </ul>
    </section>

    <section>
      <h4>Alertas de Inventario</h4>
      <div class="alert alert-success" role="alert">
        ¡No hay productos con stock bajo actualmente!
      </div>
    </section>
  </main>
</body>
</html>
