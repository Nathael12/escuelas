<?php
include("common/conexion.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM escuelas WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: index.php");
    exit;
} else {
    echo "Error al eliminar: " . $conn->error;
}
?>
