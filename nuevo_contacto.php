<?php
require_once("funciones.php");
verificar_sesion();

$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['errores']);

$token = obtener_token();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo contacto</title>
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow p-4">
                    <h2 class="text-center mb-4">Nuevo contacto</h2>

                    <?php foreach ($errores as $error): ?>
                        <div class="alert alert-danger"><?= escape_html($error) ?></div>
                    <?php endforeach; ?>

                    <form method="POST" action="guardar_contacto.php">
                        <input type="hidden" name="token" value="<?= escape_html($token) ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" maxlength="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control" maxlength="20"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" name="correo" id="correo" class="form-control" maxlength="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad:</label>
                            <input type="text" name="ciudad" id="ciudad" class="form-control" maxlength="100" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="favorito" id="favorito" value="1" class="form-check-input">
                            <label for="favorito" class="form-check-label">Marcar como favorito ★</label>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <input type="submit" value="Guardar contacto" class="btn btn-primary">
                            <a href="panel.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>