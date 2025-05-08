<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

// Obtener la lista de clientes desde la base de datos
$resultado = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes - Nova Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Lista de Clientes</h3>

    <!-- Botón para agregar un nuevo cliente -->
    <a href="agregar_cliente.php" class="btn btn-primary mb-3">Agregar Cliente</a>

    <!-- Tabla para listar los clientes -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['correo']) ?></td>
                    <td><?= htmlspecialchars($fila['telefono']) ?></td>
                    <td>
                        <!-- Enlace para editar el cliente -->
                        <a href="editar_cliente.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <!-- Enlace para eliminar el cliente -->
                        <a href="eliminar_cliente.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>
</body>
</html>
