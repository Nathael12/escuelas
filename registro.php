<?php
include("common/conexion.php");

// Buscar si se envió algo
$busqueda = "";
if (!empty($_GET['q'])) {
    $busqueda = $_GET['q'];
    $sql = "SELECT * FROM escuelas 
            WHERE nombre_escuela LIKE '%$busqueda%' 
            OR comunidad LIKE '%$busqueda%' 
            OR nivel_escolar LIKE '%$busqueda%' 
            OR cct LIKE '%$busqueda%'";
} else {
    $sql = "SELECT * FROM escuelas";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escuelas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="text-center mb-4">Estadística Escolar</h2>

    <form method="get" class="d-flex mb-3">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar escuela, comunidad, CCT..." value="<?= htmlspecialchars($busqueda) ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
        <a href="index.php" class="btn btn-success ms-2">Inicio</a>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Escuela</th>
                <th>Comunidad</th>
                <th>Nivel</th>
                <th>Niñas</th>
                <th>Niños</th>
                <th>Maestras</th>
                <th>Maestros</th>
                <th>Zona</th>
                <th>CCT</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nombre_escuela'] ?></td>
                    <td><?= $row['comunidad'] ?></td>
                    <td><?= $row['nivel_escolar'] ?></td>
                    <td><?= $row['niñas'] ?></td>
                    <td><?= $row['niños'] ?></td>
                    <td><?= $row['maestras'] ?></td>
                    <td><?= $row['maestros'] ?></td>
                    <td><?= $row['zona_escolar'] ?></td>
                    <td><?= $row['cct'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                        <a href="eliminar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar esta escuela?')">🗑️</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="11" class="text-center">No se encontraron registros.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
