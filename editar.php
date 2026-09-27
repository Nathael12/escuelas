<?php
include("common/conexion.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM escuelas WHERE id = $id");
$row = $result->fetch_assoc();

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

    $sql = "UPDATE escuelas SET 
            nombre_escuela='$nombre',
            comunidad='$comunidad',
            nivel_escolar='$nivel',
            niñas=$ninas,
            niños=$ninos,
            maestras=$maestras,
            maestros=$maestros,
            zona_escolar='$zona',
            cct='$cct'
            WHERE id=$id";

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
    <title>Editar Escuela</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="text-center mb-4">Editar Escuela</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nombre de la Escuela</label>
                <input type="text" name="nombre_escuela" class="form-control" value="<?= $row['nombre_escuela'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Comunidad</label>
                <input type="text" name="comunidad" class="form-control" value="<?= $row['comunidad'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nivel Escolar</label>
                <input type="text" name="nivel_escolar" class="form-control" value="<?= $row['nivel_escolar'] ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Niñas</label>
                <input type="number" name="niñas" class="form-control" value="<?= $row['niñas'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label>Niños</label>
                <input type="number" name="niños" class="form-control" value="<?= $row['niños'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label>Maestras</label>
                <input type="number" name="maestras" class="form-control" value="<?= $row['maestras'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label>Maestros</label>
                <input type="number" name="maestros" class="form-control" value="<?= $row['maestros'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label>Zona Escolar</label>
                <input type="text" name="zona_escolar" class="form-control" value="<?= $row['zona_escolar'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label>CCT</label>
                <input type="text" name="cct" class="form-control" value="<?= $row['cct'] ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
