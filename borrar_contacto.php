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

// recibe los datos para borrar
$id = (int) ($_POST['id'] ?? 0);
$id_usuario = $_SESSION['id_usuario'];

// borrar si el contacto es del usuario registrado
$borrar = $conexion->prepare("DELETE FROM contactos WHERE id = ? AND id_usuario = ?");
$borrar->bind_param("ii", $id, $id_usuario);
$borrar->execute();

if ($borrar->affected_rows > 0) {
    $_SESSION['mensaje'] = "Contacto eliminado correctamente.";
} else {
    $_SESSION['mensaje'] = "No se pudo eliminar el contacto.";
}

$borrar->close();
$conexion->close();

header("Location: panel.php");
exit;