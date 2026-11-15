<?php
require_once("funciones.php");

if (isset($_SESSION['id_usuario'])) {
    header("Location: panel.php");
    exit;
}

$error = $_SESSION['error_login'] ?? '';
unset($_SESSION['error_login']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow p-4">
                    <h2 class="text-center mb-4">Iniciar sesión</h2>

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger"><?= escape_html($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="validar_login.php">
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="clave" class="form-label">Contraseña:</label>
                            <input type="password" name="clave" id="clave" class="form-control" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <input type="submit" value="Ingresar" class="btn btn-primary">
                        </div>
                    </form>

                    <p class="text-center mt-3">¿No tienes cuenta? <a href="registrar.html">Regístrate</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>