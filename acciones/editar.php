<?php

require_once("../common/auth.php");
include("../common/conexion.php");

if (!isset($_GET['id'])) {
    header("Location: ../index.php");
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
        header("Location: ../index.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Escuela</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">

</head>

<body>

<?php include("../common/navbar.php"); ?>

<div class="container-fluid py-4">

    <div class="dashboard-container">

        <!-- Encabezado -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

            <div>

                <h2 class="titulo-pagina mb-1">
                    <i data-lucide="pencil" class="me-2"></i>
                    Editar Escuela
                </h2>

                <p class="subtitulo-pagina mb-0">
                    Modifica la información registrada de la escuela.
                </p>

            </div>

            <a href="../registro.php" class="btn btn-outline-secondary mt-3 mt-md-0">

                <i data-lucide="arrow-left" class="me-1"></i>
                Regresar

            </a>

        </div>

        <!-- Formulario -->
        <div class="card card-panel shadow-sm">

            <div class="card-header py-3">

                <i data-lucide="school" class="me-2"></i>
                Información de la escuela

            </div>

            <div class="card-body p-4">

                <form method="POST">

                    <div class="row">

                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">

                            <label for="nombre_escuela" class="form-label fw-semibold">
                                Nombre de la Escuela
                            </label>

                            <input
                                type="text"
                                name="nombre_escuela"
                                id="nombre_escuela"
                                class="form-control"
                                value="<?= htmlspecialchars($row['nombre_escuela']) ?>"
                                required
                            >

                        </div>

                        <!-- Comunidad -->
                        <div class="col-md-6 mb-3">

                            <label for="comunidad" class="form-label fw-semibold">
                                Comunidad
                            </label>

                            <input
                                type="text"
                                name="comunidad"
                                id="comunidad"
                                class="form-control"
                                value="<?= htmlspecialchars($row['comunidad']) ?>"
                                required
                            >

                        </div>

                        <!-- Nivel -->
                        <div class="col-md-6 mb-3">

                            <label for="nivel_escolar" class="form-label fw-semibold">
                                Nivel Escolar
                            </label>

                            <input
                                type="text"
                                name="nivel_escolar"
                                id="nivel_escolar"
                                class="form-control"
                                value="<?= htmlspecialchars($row['nivel_escolar']) ?>"
                                required
                            >

                        </div>

                        <!-- Zona -->
                        <div class="col-md-3 mb-3">

                            <label for="zona_escolar" class="form-label fw-semibold">
                                Zona Escolar
                            </label>

                            <input
                                type="text"
                                name="zona_escolar"
                                id="zona_escolar"
                                class="form-control"
                                value="<?= htmlspecialchars($row['zona_escolar']) ?>"
                            >

                        </div>

                        <!-- CCT -->
                        <div class="col-md-3 mb-3">

                            <label for="cct" class="form-label fw-semibold">
                                CCT
                            </label>

                            <input
                                type="text"
                                name="cct"
                                id="cct"
                                class="form-control"
                                value="<?= htmlspecialchars($row['cct']) ?>"
                            >

                        </div>

                    </div>

                    <hr class="my-4">

                    <!-- Alumnos -->
                    <h5 class="mb-3" style="color:#173b67;">

                        <i data-lucide="users" class="me-2"></i>
                        Alumnos

                    </h5>

                    <div class="row">

                        <div class="col-md-3 mb-3">

                            <label for="niñas" class="form-label fw-semibold">
                                Niñas
                            </label>

                            <input
                                type="number"
                                name="niñas"
                                id="niñas"
                                class="form-control"
                                value="<?= $row['niñas'] ?>"
                                min="0"
                            >

                        </div>

                        <div class="col-md-3 mb-3">

                            <label for="niños" class="form-label fw-semibold">
                                Niños
                            </label>

                            <input
                                type="number"
                                name="niños"
                                id="niños"
                                class="form-control"
                                value="<?= $row['niños'] ?>"
                                min="0"
                            >

                        </div>

                    </div>

                    <!-- Docentes -->
                    <h5 class="mb-3 mt-3" style="color:#173b67;">

                        <i data-lucide="graduation-cap" class="me-2"></i>
                        Docentes

                    </h5>

                    <div class="row">

                        <div class="col-md-3 mb-3">

                            <label for="maestras" class="form-label fw-semibold">
                                Maestras
                            </label>

                            <input
                                type="number"
                                name="maestras"
                                id="maestras"
                                class="form-control"
                                value="<?= $row['maestras'] ?>"
                                min="0"
                            >

                        </div>

                        <div class="col-md-3 mb-3">

                            <label for="maestros" class="form-label fw-semibold">
                                Maestros
                            </label>

                            <input
                                type="number"
                                name="maestros"
                                id="maestros"
                                class="form-control"
                                value="<?= $row['maestros'] ?>"
                                min="0"
                            >

                        </div>

                    </div>

                    <hr class="my-4">

                    <!-- Botones -->
                    <div class="d-flex flex-column flex-sm-row gap-2">

                        <button type="submit" class="btn btn-warning px-4">

                            <i data-lucide="save" class="me-1"></i>
                            Actualizar Escuela

                        </button>

                        <a href="../registro.php" class="btn btn-secondary px-4">

                            <i data-lucide="x" class="me-1"></i>
                            Cancelar

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="../css/bootstrap.min.js"></script>
<script src="../librerias/lucide/node_modules/lucide/dist/umd/lucide.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }

});
</script>

</body>
</html>