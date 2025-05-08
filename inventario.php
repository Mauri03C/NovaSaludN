<?php
$dsn = "mysql:host=localhost;dbname=clinica;charset=utf8";
$usuario = "root";
$contrasena = "";

try {
    $conexion = new PDO($dsn, $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar los productos en inventario
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $conexion->prepare("SELECT * FROM inventario");
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($productos);  // Devolver productos en formato JSON
    }

    // Agregar producto al inventario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombreProducto'];
        $categoria = $_POST['categoriaProducto'];
        $cantidad = $_POST['cantidadProducto'];
        $precio = $_POST['precioProducto'];

        $stmt = $conexion->prepare("INSERT INTO inventario (nombre, categoria, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $categoria, $cantidad, $precio]);
        echo json_encode(["message" => "Producto agregado con éxito"]);
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
