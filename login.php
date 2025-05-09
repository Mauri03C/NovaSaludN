<?php
session_start();

// Verificar si ya está autenticado
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}

$mensaje_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los campos están vacíos
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        $mensaje_error = 'Por favor ingrese todos los campos.';
    } else {
        // Verificar usuario y contraseña
        require_once 'includes/db.php';
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        // Preparar la consulta SQL para buscar al usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $usuario_db = $resultado->fetch_assoc();
            // Verificar contraseña con hash
            if (password_verify($password, $usuario_db['password'])) {
                // Guardar los datos del usuario en la sesión
                $_SESSION['usuario'] = $usuario_db['usuario'];
                $_SESSION['rol'] = $usuario_db['rol']; // Guardamos el rol también
                header("Location: dashboard.php");
                exit();
            } else {
                $mensaje_error = 'Contraseña incorrecta.';
            }
        } else {
            $mensaje_error = 'El usuario no existe.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Nova Salud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="text-center mb-4">Iniciar Sesión - Nova Salud</h3>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <?php if ($mensaje_error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($mensaje_error) ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
