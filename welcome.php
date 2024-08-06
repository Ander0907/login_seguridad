<?php
session_start();
require_once 'config.php'; // Asegúrate de que este archivo contenga tu clave secreta y otras configuraciones

// Verificar el token en la cookie
if (!isset($_COOKIE['token']) || !isset($_SESSION['token']) || $_COOKIE['token'] !== $_SESSION['token']) {
    header("Location: login.php");
    exit();
}

// Verificar la sesión de usuario
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verificar tiempo de inactividad
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    session_unset();
    session_destroy();
    setcookie('token', '', time() - 3600, "/", "", false, true); // Eliminar la cookie
    header("Location: index.php");
    exit();
}

// Actualizar la última actividad
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <a href="logout.php">Cerrar Sesión</a>
    <script src="session_check.js"></script>
    <script>
        let timer;

        function startTimer() {
            timer = setTimeout(logout, 60000);  // 1 minuto = 60000 ms
        }

        function resetTimer() {
            clearTimeout(timer);
            startTimer();
        }

        function logout() {
            navigator.sendBeacon('logout.php');
            window.location.href = 'index.php';
        }

        window.onload = startTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;
        window.ontouchstart = resetTimer;
        window.onclick = resetTimer;
        window.onkeypress = resetTimer;

        window.addEventListener('beforeunload', function() {
            navigator.sendBeacon('logout.php');
        });
    </script>
</body>
</html>
