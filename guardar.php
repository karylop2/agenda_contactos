<?php
require_once("conexion.php");
require_once("funciones.php");

// trim() quita espacios al inicio y al final
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$clave  = $_POST['clave'] ?? '';

// Valida los campos
$errores = [];

if ($nombre === '') {
    $errores[] = "El nombre es obligatorio.";
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo no es válido.";
}
if (strlen($clave) < 8 || strlen($clave) > 20) {
    $errores[] = "La contraseña debe tener entre 8 y 20 caracteres.";
}

if (empty($errores)) {
    // VERIFICA SI EL CORREO YA EXISTE
    $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $verificar->bind_param("s", $correo);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        $errores[] = "Este correo ya está registrado.";
    } else {
        //contraseña con hash().
        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

        // Insertar
        $insertar = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
        $insertar->bind_param("sss", $nombre, $correo, $clave_hash);

        if ($insertar->execute()) {
            $exito = true;
        } else {
            $errores[] = "Error al registrar el usuario.";
        }
        $insertar->close();
    }
    $verificar->close();
}
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
   <link href="css/estilos.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow p-4 text-center">
                    <?php if (!empty($exito)): ?>
                        <div class="alert alert-success">Usuario registrado correctamente.</div>
                        <a href="login.php" class="btn btn-primary">Iniciar sesión</a>
                    <?php else: ?>
                        <?php foreach ($errores as $error): ?>
                            <div class="alert alert-danger"><?= escape_html($error) ?></div>
                        <?php endforeach; ?>
                        <a href="registrar.html" class="btn btn-secondary">Volver</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>