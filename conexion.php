<?php
//variables para base
$servidor   = "localhost";
$usuario    = "root";
$contrasena = "";
$basedatos  = "agenda_db";

//conexion
$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

//error de conexion
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos.");
}

//para aceptar caracteres especialess
$conexion->set_charset("utf8mb4");