<?php
    include("common/conexion.php");

    $totales = $conn->query("
        SELECT 
            SUM(`niñas`) as total_ninas,
            SUM(`niños`) as total_ninos,
            SUM(maestras) as total_maestras,
            SUM(maestros) as total_maestros
        FROM escuelas
    ")->fetch_assoc();

    $niveles = $conn->query("
        SELECT nivel_escolar, COUNT(*) as cantidad
        FROM escuelas
        GROUP BY nivel_escolar
    ");
    $labels_niveles = [];
    $data_niveles = [];
    while($row = $niveles->fetch_assoc()){
        $labels_niveles[] = $row['nivel_escolar'];
        $data_niveles[] = $row['cantidad'];
    }

    $alumnos_nivel = $conn->query("
        SELECT 
            nivel_escolar,
            SUM(niñas) as total_ninas,
            SUM(niños) as total_ninos
        FROM escuelas 
        GROUP BY nivel_escolar
    ");
    $labels_alumnos_nivel = [];
    $data_ninas_nivel = [];
    $data_ninos_nivel = [];
    while($row = $alumnos_nivel->fetch_assoc()){
        $labels_alumnos_nivel[] = $row['nivel_escolar'];
        $data_ninas_nivel[] = $row['total_ninas'];
        $data_ninos_nivel[] = $row['total_ninos'];
    }

    $docentes_nivel = $conn->query("
        SELECT 
            nivel_escolar,
            SUM(maestras) as total_maestras,
            SUM(maestros) as total_maestros
        FROM escuelas 
        GROUP BY nivel_escolar
    ");
    $labels_docentes_nivel = [];
    $data_maestras_nivel = [];
    $data_maestros_nivel = [];
    while($row = $docentes_nivel->fetch_assoc()){
        $labels_docentes_nivel[] = $row['nivel_escolar'];
        $data_maestras_nivel[] = $row['total_maestras'];
        $data_maestros_nivel[] = $row['total_maestros'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Panel Estadísticas Escolares</title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .grafica-container {
            height: 280px !important;
            width: 100% !important;
            position: relative;
        }
        .card-grafica {
            height: 360px;
            margin-bottom: 1.5rem;
        }
        .card-grafica h5 {
            margin-bottom: 1rem;
            color: #495057;
        }
        .btn-volver {
            margin-top: 2rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary mb-3">📊 Panel de Estadísticas</h1>
        <p class="lead text-muted">Visualización completa de datos escolares</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card card-grafica shadow-sm p-3 bg-white">
                <h5 class="text-center mb-3">👧👦 Total Alumnos</h5>
                <div class="grafica-container">
                    <canvas id="graficaAlumnos"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-grafica shadow-sm p-3 bg-white">
                <h5 class="text-center mb-3">👩‍🏫👨‍🏫 Total Docentes</h5>
                <div class="grafica-container">
                    <canvas id="graficaDocentes"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-grafica shadow-sm p-3 bg-white">
                <h5 class="text-center mb-3">🏫 Escuelas por Nivel</h5>
                <div class="grafica-container">
                    <canvas id="graficaNiveles"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card card-grafica shadow-sm p-3 bg-white">
                <h5 class="text-center mb-3">👧👦 Alumnos por Nivel Escolar</h5>
                <div class="grafica-container">
                    <canvas id="graficaAlumnosNivel"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-grafica shadow-sm p-3 bg-white">
                <h5 class="text-center mb-3">👩‍🏫👨‍🏫 Docentes por Nivel Escolar</h5>
                <div class="grafica-container">
                    <canvas id="graficaDocentesNivel"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="index.php" class="btn btn-secondary btn-lg btn-volver shadow-sm">
            ⬅️ Volver al Panel Principal
        </a>
    </div>
</div>

<script>

const configBase = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
        }
    }
};

new Chart(document.getElementById('graficaAlumnos'), {
    type: 'bar',
    data: {
        labels: ['👧 Niñas', '👦 Niños'],
        datasets: [{
            label: 'Total General',
            data: [<?= $totales['total_ninas'] ?? 0 ?>, <?= $totales['total_ninos'] ?? 0 ?>],
            backgroundColor: ['#ff6384', '#36a2eb'],
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: configBase
});

new Chart(document.getElementById('graficaDocentes'), {
    type: 'bar',
    data: {
        labels: ['👩‍🏫 Maestras', '👨‍🏫 Maestros'],
        datasets: [{
            label: 'Total General',
            data: [<?= $totales['total_maestras'] ?? 0 ?>, <?= $totales['total_maestros'] ?? 0 ?>],
            backgroundColor: ['#8e44ad', '#2ecc71'],
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: configBase
});

new Chart(document.getElementById('graficaNiveles'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($labels_niveles) ?>,
        datasets: [{
            data: <?= json_encode($data_niveles) ?>,
            backgroundColor: [
                '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', 
                '#9966ff', '#e67e22', '#f7464a', '#00a0b0'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: configBase
});

new Chart(document.getElementById('graficaAlumnosNivel'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels_alumnos_nivel) ?>,
        datasets: [
            {
                label: '👧 Niñas',
                data: <?= json_encode($data_ninas_nivel) ?>,
                backgroundColor: '#ff6384',
                borderRadius: 4
            },
            {
                label: '👦 Niños', 
                data: <?= json_encode($data_ninos_nivel) ?>,
                backgroundColor: '#36a2eb',
                borderRadius: 4
            }
        ]
    },
    options: {
        ...configBase,
        scales: {
            x: { stacked: true },
            y: { 
                stacked: true,
                beginAtZero: true,
                title: { display: true, text: 'Cantidad de Alumnos' }
            }
        }
    }
});

new Chart(document.getElementById('graficaDocentesNivel'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels_docentes_nivel) ?>,
        datasets: [
            {
                label: '👩‍🏫 Maestras',
                data: <?= json_encode($data_maestras_nivel) ?>,
                backgroundColor: '#8e44ad',
                borderRadius: 4
            },
            {
                label: '👨‍🏫 Maestros',
                data: <?= json_encode($data_maestros_nivel) ?>,
                backgroundColor: '#2ecc71',
                borderRadius: 4
            }
        ]
    },
    options: {
        ...configBase,
        scales: {
            x: { stacked: true },
            y: { 
                stacked: true,
                beginAtZero: true,
                title: { display: true, text: 'Cantidad de Docentes' }
            }
        }
    }
});
</script>

</body>
</html>