<?php
require_once("funciones.php");

// Punto de entrada: con sesión va al panel, sin sesión al login
if (isset($_SESSION['id_usuario'])) {
    header("Location: panel.php");
} else {
    header("Location: login.php");
}
exit;