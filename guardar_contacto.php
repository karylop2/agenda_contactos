<?php
require_once("conexion.php");
require_once("funciones.php");

// funcion donde verifica el usuario autentificado
verificar_sesion();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: panel.php");
    exit;
}

// valida el token que se creo en funciones
validar_token($_POST['token'] ?? '');

// recibe los datos
$nombre   = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo   = trim($_POST['correo'] ?? '');
$ciudad   = trim($_POST['ciudad'] ?? '');
$favorito = isset($_POST['favorito']) ? 1 : 0;

// valida los datos 
$errores = [];

if ($nombre === '') {
    $errores[] = "El nombre es obligatorio.";
}
if (!preg_match('/^[0-9+\-\s]{7,20}$/', $telefono)) {
    $errores[] = "El teléfono solo puede tener números, espacios, + o - (de 7 a 20 caracteres).";
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo no es válido.";
}
if ($ciudad === '') {
    $errores[] = "La ciudad es obligatoria.";
}

if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    header("Location: nuevo_contacto.php");
    exit;
}

// inserta ya los datos obtenidos del usuario registrado
$id_usuario = $_SESSION['id_usuario'];

$insertar = $conexion->prepare("INSERT INTO contactos (id_usuario, nombre, telefono, correo, ciudad, favorito) VALUES (?, ?, ?, ?, ?, ?)");
$insertar->bind_param("issssi", $id_usuario, $nombre, $telefono, $correo, $ciudad, $favorito);

if ($insertar->execute()) {
    $_SESSION['mensaje'] = "Contacto guardado correctamente.";
} else {
    $_SESSION['mensaje'] = "No se pudo guardar el contacto.";
}

$insertar->close();
$conexion->close();

header("Location: panel.php");
exit;