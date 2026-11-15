<?php
//para iniciar sesión
if (session_status() == PHP_SESSION_NONE){
    session_start();
}

//evitar texto malicioso
function escape_html($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

//activar sesión
function verificar_sesion(){
    if (!isset($_SESSION['id_usuario'])){
        header("Location: login.php");
        exit;
    }
}

//token CSRF
function obtener_token() {
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['token'];
}

//comprobar si el token es correcto
function validar_token($token_recibido) {
    if (!isset($_SESSION['token']) || !hash_equals($_SESSION['token'], $token_recibido ?? '')) {
        exit("Solicitud no válida.");
    }
}