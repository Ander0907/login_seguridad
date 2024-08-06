<?php
session_start();

// Configuración del tiempo de inactividad
$timeout = 60; // Tiempo de espera en segundos

// Verificar si la sesión ha sido iniciada
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    // La sesión ha expirado
    session_unset(); // Limpiar variables de sesión
    session_destroy(); // Destruir sesión
    header("Location: login.php"); // Redirigir al formulario de login
    exit();
}

// Actualizar el tiempo de última actividad
$_SESSION['last_activity'] = time();
?>
