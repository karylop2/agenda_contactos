<?php
require_once("funciones.php");

// Vaciar y destruir la sesión
$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;