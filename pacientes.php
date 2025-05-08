<?php
$dsn = "mysql:host=localhost;dbname=clinica;charset=utf8";
$usuario = "root";
$contrasena = "";

try {
    $conexion = new PDO($dsn, $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todos los pacientes (para la solicitud GET)
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $conexion->prepare("SELECT id, nombre FROM pacientes");  // Selecciona solo el id y nombre para el select
        $stmt->execute();
        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($pacientes);
    }

    // Registrar paciente (para la solicitud POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recibir los datos desde la solicitud POST
        $data = json_decode(file_get_contents("php://input"), true);  // Usamos JSON para recibir datos

        // Verificar si se recibieron los datos correctamente
        if (isset($data['nombrePaciente'], $data['dniPaciente'], $data['telefonoPaciente'])) {
            $nombre = $data['nombrePaciente'];
            $dni = $data['dniPaciente'];
            $telefono = $data['telefonoPaciente'];

            // Preparar la inserción en la base de datos
            $stmt = $conexion->prepare("INSERT INTO pacientes (nombre, dni, telefono) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $dni, $telefono]);

            echo json_encode(["message" => "Paciente registrado con éxito"]);
        } else {
            echo json_encode(["error" => "Faltan datos para registrar el paciente"]);
        }
    }

} catch (Exception $e) {
    die(json_encode(["error" => "Error de conexión: " . $e->getMessage()]));
}
?>
