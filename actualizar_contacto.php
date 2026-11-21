<?php
require_once("conexion.php");
require_once("funciones.php");

// verifica la sesión
verificar_sesion();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: panel.php");
    exit;
}

// valida el token
validar_token($_POST['token'] ?? '');

// recibe los datos para actualizar
$id       = (int) ($_POST['id'] ?? 0);
$nombre   = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo   = trim($_POST['correo'] ?? '');
$ciudad   = trim($_POST['ciudad'] ?? '');
$favorito = isset($_POST['favorito']) ? 1 : 0;0 ;

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
    header("Location: editar_contacto.php?id=" . $id);
    exit;
}

// actualiza si el contacto es del usuario registrado
$id_usuario = $_SESSION['id_usuario'];

$actualizar = $conexion->prepare("UPDATE contactos SET nombre = ?, telefono = ?, correo = ?, ciudad = ?, favorito = ? WHERE id = ? AND id_usuario = ?");
$actualizar->bind_param("ssssiii", $nombre, $telefono, $correo, $ciudad, $favorito, $id, $id_usuario, );
$actualizar->execute();


if ($actualizar->affected_rows > 0) {
    $_SESSION['mensaje'] = "Contacto actualizado correctamente.";
} else {
    $_SESSION['mensaje'] = "No se realizaron cambios.";
}

$actualizar->close();
$conexion->close();

header("Location: panel.php");
exit;