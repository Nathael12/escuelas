<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark navbar-escolar shadow-sm">
    <div class="container-fluid px-4">

        <a class="navbar-brand fw-bold d-flex align-items-center" href="/escuelas/index.php">
            <i data-lucide="school"></i>
            Registro Escolar
        </a>

        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarPrincipal"
            aria-controls="navbarPrincipal"
            aria-expanded="false"
            aria-label="Mostrar menú"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarPrincipal">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="/escuelas/index.php">
                        <i data-lucide="layout-dashboard" class="nav-icon"></i>
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/escuelas/registro.php">
                        <i data-lucide="school" class="nav-icon"></i>
                        Escuelas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/escuelas/grafica.php">
                        <i data-lucide="bar-chart-3" class="nav-icon"></i>
                        Estadísticas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/escuelas/acciones/agregar.php">
                        <i data-lucide="plus-circle" class="nav-icon"></i>
                        Agregar escuela
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center">

                <span class="navbar-text me-3 d-none d-lg-flex align-items-center">
                    <i data-lucide="user" class="nav-icon me-1"></i>
                    Administrador
                </span>

                <a href="/escuelas/logout.php" class="btn btn-outline-light btn-sm">
                    <i data-lucide="log-out" class="nav-icon"></i>
                    Salir
                </a>

            </div>

        </div>
    </div>
</nav>