<?php
require_once '../../includes/db.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit();
}

$id_venta = $_GET['id'];

// Eliminar la venta
$conn->query("DELETE FROM ventas WHERE id = $id_venta");

header("Location: ventas.php");
exit();
