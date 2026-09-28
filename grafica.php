<?php

require_once("common/auth.php");
include("common/conexion.php");

/* =========================================================
   DATOS GENERALES
   ========================================================= */

$sqlTotal = "SELECT 
                COUNT(*) AS total_escuelas,
                COALESCE(SUM(niñas), 0) AS total_niñas,
                COALESCE(SUM(niños), 0) AS total_niños,
                COALESCE(SUM(maestras), 0) AS total_maestras,
                COALESCE(SUM(maestros), 0) AS total_maestros
             FROM escuelas";

$resultTotal = $conn->query($sqlTotal);
$totales = $resultTotal->fetch_assoc();

$totalEscuelas = (int)$totales['total_escuelas'];
$totalNiñas = (int)$totales['total_niñas'];
$totalNiños = (int)$totales['total_niños'];
$totalMaestras = (int)$totales['total_maestras'];
$totalMaestros = (int)$totales['total_maestros'];

$totalAlumnos = $totalNiñas + $totalNiños;
$totalDocentes = $totalMaestras + $totalMaestros;


/* =========================================================
   ESCUELAS POR NIVEL
   ========================================================= */

$sqlNivel = "SELECT 
                nivel_escolar,
                COUNT(*) AS cantidad
             FROM escuelas
             GROUP BY nivel_escolar
             ORDER BY nivel_escolar";

$resultNivel = $conn->query($sqlNivel);

$niveles = [];
$cantidadNiveles = [];

while ($fila = $resultNivel->fetch_assoc()) {
    $niveles[] = $fila['nivel_escolar'];
    $cantidadNiveles[] = (int)$fila['cantidad'];
}


/* =========================================================
   ALUMNOS POR NIVEL
   ========================================================= */

$sqlAlumnosNivel = "SELECT 
                        nivel_escolar,
                        COALESCE(SUM(niñas), 0) AS niñas,
                        COALESCE(SUM(niños), 0) AS niños
                    FROM escuelas
                    GROUP BY nivel_escolar
                    ORDER BY nivel_escolar";

$resultAlumnosNivel = $conn->query($sqlAlumnosNivel);

$nivelesAlumnos = [];
$niñasNivel = [];
$niñosNivel = [];

while ($fila = $resultAlumnosNivel->fetch_assoc()) {
    $nivelesAlumnos[] = $fila['nivel_escolar'];
    $niñasNivel[] = (int)$fila['niñas'];
    $niñosNivel[] = (int)$fila['niños'];
}


/* =========================================================
   DOCENTES POR NIVEL
   ========================================================= */

$sqlDocentesNivel = "SELECT 
                        nivel_escolar,
                        COALESCE(SUM(maestras), 0) AS maestras,
                        COALESCE(SUM(maestros), 0) AS maestros
                     FROM escuelas
                     GROUP BY nivel_escolar
                     ORDER BY nivel_escolar";

$resultDocentesNivel = $conn->query($sqlDocentesNivel);

$nivelesDocentes = [];
$maestrasNivel = [];
$maestrosNivel = [];

while ($fila = $resultDocentesNivel->fetch_assoc()) {
    $nivelesDocentes[] = $fila['nivel_escolar'];
    $maestrasNivel[] = (int)$fila['maestras'];
    $maestrosNivel[] = (int)$fila['maestros'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Estadísticas - Registro Escolar</title>

    <link rel="stylesheet"
          href="css/bootstrap.min.css">

    <link rel="stylesheet"
          href="css/estilos.css">

</head>

<body>

<?php include("common/navbar.php"); ?>


<main class="container-fluid py-4">

    <div class="dashboard-container">

        <!-- =====================================================
             ENCABEZADO
             ===================================================== -->

        <div class="mb-4">

            <h1 class="titulo-pagina">
                <i data-lucide="bar-chart-3"></i>
                Estadísticas escolares
            </h1>

            <p class="subtitulo-pagina mb-0">
                Resumen general de la información registrada en el sistema.
            </p>

        </div>


        <!-- =====================================================
             TARJETAS DE RESUMEN
             ===================================================== -->

        <div class="row g-4 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card card-resumen shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="texto-resumen">
                                    Escuelas
                                </p>

                                <p class="numero-resumen">
                                    <?php echo $totalEscuelas; ?>
                                </p>

                            </div>

                            <i data-lucide="school"
                               class="icono-resumen text-primary"></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card card-resumen shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="texto-resumen">
                                    Alumnos
                                </p>

                                <p class="numero-resumen">
                                    <?php echo $totalAlumnos; ?>
                                </p>

                            </div>

                            <i data-lucide="users"
                               class="icono-resumen text-success"></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card card-resumen shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="texto-resumen">
                                    Docentes
                                </p>

                                <p class="numero-resumen">
                                    <?php echo $totalDocentes; ?>
                                </p>

                            </div>

                            <i data-lucide="graduation-cap"
                               class="icono-resumen text-warning"></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card card-resumen shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="texto-resumen">
                                    Niñas y niños
                                </p>

                                <p class="numero-resumen">
                                    <?php echo $totalNiñas + $totalNiños; ?>
                                </p>

                            </div>

                            <i data-lucide="baby"
                               class="icono-resumen text-info"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             GRÁFICAS
             ===================================================== -->

        <div class="row g-4">


            <!-- TOTAL DE ALUMNOS -->

            <div class="col-12 col-lg-6">

                <div class="card card-panel shadow-sm">

                    <div class="card-header p-3">

                        <div class="d-flex align-items-center gap-2">

                            <i data-lucide="users"></i>

                            <span>
                                Total de alumnos
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="grafica-container">

                            <canvas id="graficaAlumnos"></canvas>

                        </div>

                    </div>

                </div>

            </div>


            <!-- TOTAL DE DOCENTES -->

            <div class="col-12 col-lg-6">

                <div class="card card-panel shadow-sm">

                    <div class="card-header p-3">

                        <div class="d-flex align-items-center gap-2">

                            <i data-lucide="graduation-cap"></i>

                            <span>
                                Total de docentes
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="grafica-container">

                            <canvas id="graficaDocentes"></canvas>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ESCUELAS POR NIVEL -->

            <div class="col-12 col-lg-6">

                <div class="card card-panel shadow-sm">

                    <div class="card-header p-3">

                        <div class="d-flex align-items-center gap-2">

                            <i data-lucide="school"></i>

                            <span>
                                Escuelas por nivel escolar
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="grafica-container">

                            <canvas id="graficaNiveles"></canvas>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ALUMNOS POR NIVEL -->

            <div class="col-12 col-lg-6">

                <div class="card card-panel shadow-sm">

                    <div class="card-header p-3">

                        <div class="d-flex align-items-center gap-2">

                            <i data-lucide="bar-chart-3"></i>

                            <span>
                                Alumnos por nivel escolar
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="grafica-container">

                            <canvas id="graficaAlumnosNivel"></canvas>

                        </div>

                    </div>

                </div>

            </div>


            <!-- DOCENTES POR NIVEL -->

            <div class="col-12">

                <div class="card card-panel shadow-sm">

                    <div class="card-header p-3">

                        <div class="d-flex align-items-center gap-2">

                            <i data-lucide="bar-chart-horizontal"></i>

                            <span>
                                Docentes por nivel escolar
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="grafica-container grafica-grande">

                            <canvas id="graficaDocentesNivel"></canvas>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>


<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       ICONOS
       ===================================================== */

    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }


    /* =====================================================
       GRÁFICA TOTAL DE ALUMNOS
       ===================================================== */

    new Chart(
        document.getElementById("graficaAlumnos"),
        {
            type: "bar",

            data: {

                labels: ["Niñas", "Niños"],

                datasets: [
                    {
                        label: "Alumnos",

                        data: [
                            <?php echo $totalNiñas; ?>,
                            <?php echo $totalNiños; ?>
                        ],

                        backgroundColor: [
                            "#e83e8c",
                            "#0d6efd"
                        ],

                        borderRadius: 8
                    }
                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        }
    );


    /* =====================================================
       GRÁFICA TOTAL DE DOCENTES
       ===================================================== */

    new Chart(
        document.getElementById("graficaDocentes"),
        {
            type: "bar",

            data: {

                labels: ["Maestras", "Maestros"],

                datasets: [
                    {
                        label: "Docentes",

                        data: [
                            <?php echo $totalMaestras; ?>,
                            <?php echo $totalMaestros; ?>
                        ],

                        backgroundColor: [
                            "#6f42c1",
                            "#20c997"
                        ],

                        borderRadius: 8
                    }
                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        }
    );


    /* =====================================================
       ESCUELAS POR NIVEL
       ===================================================== */

    new Chart(
        document.getElementById("graficaNiveles"),
        {
            type: "doughnut",

            data: {

                labels: <?php echo json_encode($niveles); ?>,

                datasets: [
                    {
                        data: <?php echo json_encode($cantidadNiveles); ?>,

                        backgroundColor: [
                            "#0d6efd",
                            "#198754",
                            "#ffc107",
                            "#dc3545",
                            "#6f42c1",
                            "#20c997",
                            "#fd7e14"
                        ]
                    }
                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        position: "bottom"
                    }

                }

            }

        }
    );


    /* =====================================================
       ALUMNOS POR NIVEL
       ===================================================== */

    new Chart(
        document.getElementById("graficaAlumnosNivel"),
        {
            type: "bar",

            data: {

                labels: <?php echo json_encode($nivelesAlumnos); ?>,

                datasets: [

                    {
                        label: "Niñas",

                        data: <?php echo json_encode($niñasNivel); ?>,

                        backgroundColor: "#e83e8c",

                        borderRadius: 6
                    },

                    {
                        label: "Niños",

                        data: <?php echo json_encode($niñosNivel); ?>,

                        backgroundColor: "#0d6efd",

                        borderRadius: 6
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    x: {
                        stacked: true
                    },

                    y: {

                        stacked: true,

                        beginAtZero: true

                    }

                }

            }

        }
    );


    /* =====================================================
       DOCENTES POR NIVEL
       ===================================================== */

    new Chart(
        document.getElementById("graficaDocentesNivel"),
        {
            type: "bar",

            data: {

                labels: <?php echo json_encode($nivelesDocentes); ?>,

                datasets: [

                    {
                        label: "Maestras",

                        data: <?php echo json_encode($maestrasNivel); ?>,

                        backgroundColor: "#6f42c1",

                        borderRadius: 6
                    },

                    {
                        label: "Maestros",

                        data: <?php echo json_encode($maestrosNivel); ?>,

                        backgroundColor: "#20c997",

                        borderRadius: 6
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    x: {
                        stacked: true
                    },

                    y: {

                        stacked: true,

                        beginAtZero: true

                    }

                }

            }

        }
    );

});

</script>

</body>

</html>