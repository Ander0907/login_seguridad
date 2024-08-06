<?php
session_start();
setcookie('token', '', time() - 3600, "/", "", false, true); // Eliminar la cookie
unset($_SESSION['token']); // Eliminar el token de la sesión
session_unset(); // Limpiar variables de sesión
session_destroy(); // Destruir sesión
header("Location: login.php");
exit();
?>
