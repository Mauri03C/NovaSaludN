<?php
$dsn = "mysql:host=localhost;dbname=clinica;charset=utf8";
$usuario = "root";
$contrasena = "";

try {
    $conexion = new PDO($dsn, $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener productos disponibles en inventario
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['productos'])) {
        $stmt = $conexion->prepare("SELECT * FROM inventario");
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($productos);
    }

    // Obtener pacientes registrados
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pacientes'])) {
        $stmt = $conexion->prepare("SELECT * FROM pacientes");
        $stmt->execute();
        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($pacientes);
    }

    // Registrar venta
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];
        $precio_unitario = $_POST['precio_unitario'];
        $total = $cantidad * $precio_unitario;

        $paciente_id = $_POST['paciente_id'] ?? null;  // Puede ser null si el paciente no está registrado

        // Insertar venta
        $stmt = $conexion->prepare("INSERT INTO ventas (producto_id, cantidad, precio_unitario, total, paciente_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$producto_id, $cantidad, $precio_unitario, $total, $paciente_id]);
        
        // Actualizar inventario después de la venta
        $stmt = $conexion->prepare("UPDATE inventario SET cantidad = cantidad - ? WHERE id = ?");
        $stmt->execute([$cantidad, $producto_id]);

        echo json_encode(["message" => "Venta registrada con éxito"]);
    }

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
