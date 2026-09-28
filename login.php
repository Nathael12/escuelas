<?php

session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$usuario_correcto = "admin";
$contrasena_correcta = "admin123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (
        $usuario === $usuario_correcto &&
        $contrasena === $contrasena_correcta
    ) {

        $_SESSION['usuario'] = $usuario;

        header("Location: index.php");
        exit;

    } else {

        $error = "El usuario o la contraseña son incorrectos.";

    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión - Registro Escolar</title>

    <link rel="stylesheet"
          href="css/bootstrap.min.css">

    <link rel="stylesheet"
          href="css/estilos.css">


    <style>

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(
                135deg,
                #173b67,
                #24558c
            );
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(
                135deg,
                #173b67,
                #24558c
            );
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .login-icon {
            width: 55px;
            height: 55px;
            margin-bottom: 15px;
        }

        .login-body {
            padding: 30px;
        }

        .form-control {
            min-height: 46px;
            border-radius: 9px;
        }

        .btn-login {
            min-height: 48px;
            border-radius: 9px;
            font-weight: 600;
        }

        .login-footer {
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 20px;
        }

    </style>

</head>


<body>


<div class="login-container">

    <div class="card shadow-lg login-card">


        <!-- Encabezado -->

        <div class="login-header">

            <i data-lucide="school"
               class="login-icon">
            </i>

            <h2 class="mb-1">
                Registro Escolar
            </h2>

            <p class="mb-0">
                Sistema de estadísticas escolares
            </p>

        </div>


        <!-- Formulario -->

        <div class="login-body">

            <h4 class="text-center mb-4">
                Iniciar sesión
            </h4>


            <?php if ($error !== ""): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($error) ?>

                </div>

            <?php endif; ?>


            <form method="POST"
                  action="">


                <!-- Usuario -->

                <div class="mb-3">

                    <label for="usuario"
                           class="form-label">

                        Usuario

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i data-lucide="user"></i>

                        </span>

                        <input
                            type="text"
                            class="form-control"
                            id="usuario"
                            name="usuario"
                            placeholder="Ingresa tu usuario"
                            required
                            autocomplete="username"
                        >

                    </div>

                </div>


                <!-- Contraseña -->

                <div class="mb-4">

                    <label for="contrasena"
                           class="form-label">

                        Contraseña

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i data-lucide="lock"></i>

                        </span>

                        <input
                            type="password"
                            class="form-control"
                            id="contrasena"
                            name="contrasena"
                            placeholder="Ingresa tu contraseña"
                            required
                            autocomplete="current-password"
                        >

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-login w-100">

                    <i data-lucide="log-in"
                       class="me-2">
                    </i>

                    Iniciar sesión

                </button>


            </form>


            <div class="login-footer">

                Sistema de Registro Escolar

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }
});
</script>


</body>

</html>