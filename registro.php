<?php

require_once("common/auth.php");
include("common/conexion.php");

$busqueda = "";

if (!empty($_GET['q'])) {
    $busqueda = trim($_GET['q']);

    $busqueda_segura = $conn->real_escape_string($busqueda);

    $sql = "SELECT * FROM escuelas
            WHERE nombre_escuela LIKE '%$busqueda_segura%'
            OR comunidad LIKE '%$busqueda_segura%'
            OR nivel_escolar LIKE '%$busqueda_segura%'
            OR cct LIKE '%$busqueda_segura%'";
} else {

    $sql = "SELECT * FROM escuelas";

}

$result = $conn->query($sql);

$total_escuelas = 0;

$total_resultado = $conn->query("
    SELECT COUNT(*) AS total
    FROM escuelas
");

if ($total_resultado) {

    $fila_total = $total_resultado->fetch_assoc();

    $total_escuelas = $fila_total['total'] ?? 0;

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Escuelas - Registro Escolar</title>

    <link rel="stylesheet"
          href="css/bootstrap.min.css">

    <link rel="stylesheet"
          href="css/estilos.css">

    <link rel="stylesheet"
          href="librerias/datatables/datatables.min.css">


    <style>

        .registro-container {
            max-width: 1500px;
            margin: auto;
        }

        .encabezado-registro {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .icono-titulo {
            width: 40px;
            height: 40px;
        }

        .card-registro {
            border: none;
            border-radius: 14px;
        }

        .tabla-container {
            overflow-x: auto;
        }

        .table thead th {
            white-space: nowrap;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .acciones-tabla {
            white-space: nowrap;
        }

        .btn-tabla {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
        }

        .btn-tabla svg {
            width: 16px;
            height: 16px;
        }

        .badge-total {
            font-size: 0.9rem;
            padding: 8px 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #dee2e6;
            border-radius: 7px;
            padding: 7px 10px;
            margin-left: 8px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #dee2e6;
            border-radius: 7px;
            padding: 5px 25px 5px 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px !important;
        }

        @media (max-width: 768px) {

            .encabezado-registro {
                align-items: flex-start;
            }

        }

    </style>

</head>


<body>


<?php include("common/navbar.php"); ?>


<main class="container-fluid registro-container py-4 px-3 px-md-4">

    <div class="encabezado-registro mb-4">

        <div class="d-flex align-items-center">

            <div class="me-3">

                <i data-lucide="school"
                   class="icono-titulo text-primary">
                </i>

            </div>

            <div>

                <h1 class="titulo-pagina mb-1">
                    Registro de escuelas
                </h1>

                <p class="subtitulo-pagina mb-0">
                    Consulta y administra las escuelas registradas.
                </p>

            </div>

        </div>


        <div class="d-flex align-items-center gap-2">

            <span class="badge bg-primary badge-total">

                <i data-lucide="school"
                   style="width:16px; height:16px;">
                </i>

                <?= $total_escuelas ?> escuelas

            </span>


            <a href="acciones/agregar.php"
               class="btn btn-primary">

                <i data-lucide="plus"
                   style="width:17px;">
                </i>

                Agregar escuela

            </a>

        </div>

    </div>

    <div class="card card-registro shadow-sm">

        <div class="card-body">

            <form method="get"
                  class="row g-2 mb-4">

                <div class="col-md-9">

                    <div class="input-group">

                        <span class="input-group-text">

                            <i data-lucide="search"
                               style="width:18px;">
                            </i>

                        </span>

                        <input
                            type="text"
                            name="q"
                            class="form-control"
                            placeholder="Buscar escuela, comunidad, nivel o CCT..."
                            value="<?= htmlspecialchars($busqueda) ?>"
                        >

                    </div>

                </div>


                <div class="col-md-3 d-flex gap-2">

                    <button
                        class="btn btn-primary flex-grow-1"
                        type="submit">

                        <i data-lucide="search"
                           style="width:17px;">
                        </i>

                        Buscar

                    </button>


                    <?php if ($busqueda !== ""): ?>

                        <a href="registro.php"
                           class="btn btn-outline-secondary">

                            <i data-lucide="x"
                               style="width:17px;">
                            </i>

                        </a>

                    <?php endif; ?>

                </div>

            </form>

            <div class="tabla-container">

                <table
                    id="tablaEscuelas"
                    class="table table-hover table-striped align-middle w-100">

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

                    <?php if ($result && $result->num_rows > 0): ?>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= $row['id'] ?>
                                </td>


                                <td>

                                    <strong>
                                        <?= htmlspecialchars($row['nombre_escuela']) ?>
                                    </strong>

                                </td>


                                <td>
                                    <?= htmlspecialchars($row['comunidad']) ?>
                                </td>


                                <td>

                                    <span class="badge bg-secondary">

                                        <?= htmlspecialchars($row['nivel_escolar']) ?>

                                    </span>

                                </td>


                                <td>
                                    <?= $row['niñas'] ?>
                                </td>


                                <td>
                                    <?= $row['niños'] ?>
                                </td>


                                <td>
                                    <?= $row['maestras'] ?>
                                </td>


                                <td>
                                    <?= $row['maestros'] ?>
                                </td>


                                <td>
                                    <?= htmlspecialchars($row['zona_escolar']) ?>
                                </td>


                                <td>
                                    <?= htmlspecialchars($row['cct']) ?>
                                </td>


                                <td class="acciones-tabla">

                                    <a
                                        href="acciones/editar.php?id=<?= $row['id'] ?>"
                                        class="btn btn-warning btn-tabla"
                                        title="Editar">

                                        <i data-lucide="pencil"></i>

                                    </a>


                                    <a
                                        href="acciones/eliminar.php?id=<?= $row['id'] ?>"
                                        class="btn btn-danger btn-tabla btn-eliminar"
                                        data-id="<?= $row['id'] ?>"
                                        title="Eliminar">

                                        <i data-lucide="trash-2"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="mt-4">

        <a href="index.php"
           class="btn btn-outline-secondary">

            <i data-lucide="arrow-left"
               style="width:17px;">
            </i>

            Volver al inicio

        </a>

    </div>


</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    if (typeof lucide !== "undefined") {

        lucide.createIcons();

    }

    if (typeof $ !== "undefined" &&
        typeof $.fn.DataTable !== "undefined") {

        $('#tablaEscuelas').DataTable({

            responsive: false,

            pageLength: 10,

            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todas"]
            ],

            language: {

                search: "Buscar en la tabla:",

                lengthMenu: "Mostrar _MENU_ registros",

                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",

                infoEmpty: "Mostrando 0 registros",

                infoFiltered: "(filtrado de _MAX_ registros)",

                zeroRecords: "No se encontraron registros",

                emptyTable: "No hay escuelas registradas",

                paginate: {

                    first: "Primero",

                    last: "Último",

                    next: "Siguiente",

                    previous: "Anterior"

                }

            },

            columnDefs: [

                {
                    orderable: false,
                    targets: 10
                }

            ],

            order: [

                [0, "desc"]

            ]

        });

    }

    const botonesEliminar =
        document.querySelectorAll(".btn-eliminar");


    botonesEliminar.forEach(function (boton) {

        boton.addEventListener("click", function (evento) {

            evento.preventDefault();

            const url = this.getAttribute("href");


            Swal.fire({

                title: "¿Eliminar escuela?",

                text: "Esta acción no se puede deshacer.",

                icon: "warning",

                showCancelButton: true,

                confirmButtonText: "Sí, eliminar",

                cancelButtonText: "Cancelar",

                reverseButtons: true

            }).then((resultado) => {

                if (resultado.isConfirmed) {

                    window.location.href = url;

                }

            });

        });

    });

});

</script>


</body>

</html>