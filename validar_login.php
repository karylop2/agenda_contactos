<?php
require_once("conexion.php");
require_once("funciones.php");

// Solo se aceptan datos enviados por el formulario (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

//  VALIDA DATOS RECIBIDOS
$correo = trim($_POST['correo'] ?? '');
$clave = $_POST['clave'] ?? '';

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || $clave === '') {
    $_SESSION['error_login'] = "Ingrese un correo y una contraseña válidos.";
    header("Location: login.php");
    exit;
}

// BUSCA AL USUARIO POR SU CORREO
$stmt = $conexion->prepare("SELECT id, nombre, correo, password FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();   // null si no existe
$stmt->close();
$conexion->close();

// COMPROBAR LA CONTRASEÑA 
if ($usuario && password_verify($clave, $usuario['password'])) {

    // 4. CREAR LA SESIÓN
    session_regenerate_id(true);   // nuevo id de sesión al iniciar
    $_SESSION['id_usuario'] = $usuario['id'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];

    header("Location: panel.php");
    exit;
}

// MENSAJE DE ERROR: el mismo mensaje si falla el correo o la contraseña
$_SESSION['error_login'] = "Correo o contraseña incorrectos.";
header("Location: login.php");
exit;