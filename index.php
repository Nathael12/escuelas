<?php
require_once("common/auth.php");
include("common/conexion.php");

$total_escuelas = 0;
$total_ninas = 0;
$total_ninos = 0;
$total_maestras = 0;
$total_maestros = 0;
$total_zonas = 0;

$resultado = $conn->query("SELECT COUNT(*) AS total FROM escuelas");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $total_escuelas = $fila['total'] ?? 0;
}

$resultado = $conn->query("
    SELECT
        COALESCE(SUM(`niñas`), 0) AS total_ninas,
        COALESCE(SUM(`niños`), 0) AS total_ninos
    FROM escuelas
");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $total_ninas = $fila['total_ninas'] ?? 0;
    $total_ninos = $fila['total_ninos'] ?? 0;
}

$resultado = $conn->query("
    SELECT
        COALESCE(SUM(maestras), 0) AS total_maestras,
        COALESCE(SUM(maestros), 0) AS total_maestros
    FROM escuelas
");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $total_maestras = $fila['total_maestras'] ?? 0;
    $total_maestros = $fila['total_maestros'] ?? 0;
}

$resultado = $conn->query("SELECT COUNT(DISTINCT zona_escolar) AS total FROM escuelas");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $total_zonas = $fila['total'] ?? 0;
}

$total_alumnos = $total_ninas + $total_ninos;
$total_docentes = $total_maestras + $total_maestros;

$niveles = $conn->query("
    SELECT nivel_escolar, COUNT(*) AS cantidad
    FROM escuelas
    GROUP BY nivel_escolar
    ORDER BY cantidad DESC
");

$ultimas_escuelas = $conn->query("
    SELECT id, nombre_escuela, comunidad, nivel_escolar, cct
    FROM escuelas
    ORDER BY id DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Escolar</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">

    <style>

        /* Mismos colores de Bootstrap (primary/success/warning/danger),
           solo se refinan las tarjetas de resumen y los paneles. */

        .card-resumen {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .card-resumen:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.08) !important;
        }

        .card-resumen .card-body {
            padding: 1.5rem;
        }

        .icono-circulo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icono-circulo.bg-primary-suave { background: rgba(13, 110, 253, 0.12); }
        .icono-circulo.bg-success-suave { background: rgba(25, 135, 84, 0.12); }
        .icono-circulo.bg-warning-suave { background: rgba(255, 193, 7, 0.16); }
        .icono-circulo.bg-danger-suave  { background: rgba(220, 53, 69, 0.12); }

        .icono-resumen {
            width: 22px;
            height: 22px;
        }

        .texto-resumen {
            margin: 0;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .numero-resumen {
            margin: 0;
            font-size: 1.7rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .card-resumen .btn {
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Paneles generales */

        .card-panel {
            border: none;
            border-radius: 14px;
            overflow: hidden;
        }

        .card-panel .card-header {
            background: #fff;
            border-bottom: 1px solid #eef0f2;
            font-weight: 600;
        }

        .btn-accion {
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 1rem;
        }

        .table-responsive table thead th {
            font-size: 0.82rem;
            text-transform: none;
            color: #6c757d;
            border-bottom-width: 1px;
        }

    </style>

</head>
<body>

<?php include("common/navbar.php"); ?>

<main class="container-fluid dashboard-container py-4 px-3 px-md-4">

    <div class="mb-4">
        <h1 class="titulo-pagina mb-1">Panel principal</h1>
        <p class="subtitulo-pagina mb-0">Resumen general de la información registrada en el sistema escolar.</p>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-resumen shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icono-circulo bg-primary-suave me-3">
                            <i data-lucide="school" class="icono-resumen text-primary"></i>
                        </div>
                        <div>
                            <p class="texto-resumen">Escuelas</p>
                            <p class="numero-resumen"><?= $total_escuelas ?></p>
                        </div>
                    </div>
                    <a href="registro.php" class="btn btn-primary w-100">Ver escuelas</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-resumen shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icono-circulo bg-success-suave me-3">
                            <i data-lucide="users" class="icono-resumen text-success"></i>
                        </div>
                        <div>
                            <p class="texto-resumen">Alumnos</p>
                            <p class="numero-resumen"><?= $total_alumnos ?></p>
                        </div>
                    </div>
                    <a href="grafica.php" class="btn btn-success w-100">Ver estadísticas</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-resumen shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icono-circulo bg-warning-suave me-3">
                            <i data-lucide="graduation-cap" class="icono-resumen text-warning"></i>
                        </div>
                        <div>
                            <p class="texto-resumen">Docentes</p>
                            <p class="numero-resumen"><?= $total_docentes ?></p>
                        </div>
                    </div>
                    <a href="grafica.php" class="btn btn-warning w-100">Ver estadísticas</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-resumen shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icono-circulo bg-danger-suave me-3">
                            <i data-lucide="map-pin" class="icono-resumen text-danger"></i>
                        </div>
                        <div>
                            <p class="texto-resumen">Zonas escolares</p>
                            <p class="numero-resumen"><?= $total_zonas ?></p>
                        </div>
                    </div>
                    <a href="registro.php" class="btn btn-danger w-100">Consultar</a>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card card-panel shadow-sm h-100">
                <div class="card-header p-3">
                    <i data-lucide="users" class="me-2" style="width:18px;"></i>
                    Resumen de alumnos
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="p-3">
                                <h2 class="text-danger"><?= $total_ninas ?></h2>
                                <p class="text-muted mb-0">Niñas</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3">
                                <h2 class="text-primary"><?= $total_ninos ?></h2>
                                <p class="text-muted mb-0">Niños</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-panel shadow-sm h-100">
                <div class="card-header p-3">
                    <i data-lucide="graduation-cap" class="me-2" style="width:18px;"></i>
                    Resumen de docentes
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="p-3">
                                <h2 class="text-warning"><?= $total_maestras ?></h2>
                                <p class="text-muted mb-0">Maestras</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3">
                                <h2 class="text-success"><?= $total_maestros ?></h2>
                                <p class="text-muted mb-0">Maestros</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card card-panel shadow-sm h-100">
                <div class="card-header p-3">
                    <i data-lucide="layers" class="me-2" style="width:18px;"></i>
                    Escuelas por nivel escolar
                </div>
                <div class="card-body">
                    <?php if ($niveles && $niveles->num_rows > 0): ?>
                        <?php while ($nivel = $niveles->fetch_assoc()): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span><?= htmlspecialchars($nivel['nivel_escolar']) ?></span>
                                <span class="badge bg-primary rounded-pill"><?= $nivel['cantidad'] ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">No hay información registrada.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-panel shadow-sm h-100">
                <div class="card-header p-3">
                    <i data-lucide="zap" class="me-2" style="width:18px;"></i>
                    Acciones rápidas
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="acciones/agregar.php" class="btn btn-primary btn-accion w-100">
                                <i data-lucide="plus-circle"></i>
                                Agregar escuela
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="registro.php" class="btn btn-outline-primary btn-accion w-100">
                                <i data-lucide="school"></i>
                                Ver escuelas
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="grafica.php" class="btn btn-outline-success btn-accion w-100">
                                <i data-lucide="bar-chart-3"></i>
                                Ver gráficas
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="logout.php" class="btn btn-outline-danger btn-accion w-100">
                                <i data-lucide="log-out"></i>
                                Cerrar sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card card-panel shadow-sm mb-4">
        <div class="card-header p-3 d-flex justify-content-between align-items-center">
            <span>
                <i data-lucide="school" class="me-2" style="width:18px;"></i>
                Escuelas registradas
            </span>
            <a href="registro.php" class="btn btn-sm btn-primary">Ver todas</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Escuela</th>
                            <th>Comunidad</th>
                            <th>Nivel</th>
                            <th>CCT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($ultimas_escuelas && $ultimas_escuelas->num_rows > 0): ?>
                            <?php while ($escuela = $ultimas_escuelas->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $escuela['id'] ?></td>
                                    <td><?= htmlspecialchars($escuela['nombre_escuela']) ?></td>
                                    <td><?= htmlspecialchars($escuela['comunidad']) ?></td>
                                    <td><?= htmlspecialchars($escuela['nivel_escolar']) ?></td>
                                    <td><?= htmlspecialchars($escuela['cct']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No hay escuelas registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<script src="css/bootstrap.min.js"></script>
<script src="librerias/lucide/node_modules/lucide/dist/umd/lucide.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }
});
</script>

</body>
</html>