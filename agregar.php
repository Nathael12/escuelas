<?php
include("common/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_escuela'];
    $comunidad = $_POST['comunidad'];
    $nivel = $_POST['nivel_escolar'];
    $ninas = $_POST['niñas'];
    $ninos = $_POST['niños'];
    $maestras = $_POST['maestras'];
    $maestros = $_POST['maestros'];
    $zona = $_POST['zona_escolar'];
    $cct = $_POST['cct'];

    $sql = "INSERT INTO escuelas (nombre_escuela, comunidad, nivel_escolar, niñas, niños, maestras, maestros, zona_escolar, cct)
            VALUES ('$nombre', '$comunidad', '$nivel', $ninas, $ninos, $maestras, $maestros, '$zona', '$cct')";

    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Escuela</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="text-center mb-4">Agregar Escuela</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nombre de la Escuela</label>
                <input type="text" name="nombre_escuela" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Comunidad</label>
                <input type="text" name="comunidad" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nivel Escolar</label>
                <input type="text" name="nivel_escolar" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Niñas</label>
                <input type="number" name="niñas" class="form-control" value="0">
            </div>
            <div class="col-md-3 mb-3">
                <label>Niños</label>
                <input type="number" name="niños" class="form-control" value="0">
            </div>
            <div class="col-md-3 mb-3">
                <label>Maestras</label>
                <input type="number" name="maestras" class="form-control" value="0">
            </div>
            <div class="col-md-3 mb-3">
                <label>Maestros</label>
                <input type="number" name="maestros" class="form-control" value="0">
            </div>
            <div class="col-md-3 mb-3">
                <label>Zona Escolar</label>
                <input type="text" name="zona_escolar" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label>CCT</label>
                <input type="text" name="cct" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
