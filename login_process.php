<?php
session_start();
require_once 'config.php';
require_once 'UserModel.php';

// Verificar que se haya enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = UserModel::getUserByUsername($username);
    $attempts = UserModel::getFailedAttempts($username);

    // Verificar si el usuario está bloqueado
    if ($attempts) {
        // Comprobar si el número de intentos fallidos es 3 o más
        if ($attempts['failed_attempts'] >= 3) {
            $lastAttempt = strtotime($attempts['last_failed_attempt']);
            $currentTime = time();
            // Si el bloqueo es de 1 minuto
            if ($currentTime - $lastAttempt < 60) {
                echo "Demasiados intentos fallidos. Por favor, intente nuevamente en un minuto.";
                exit();
            } else {
                // Restablecer intentos fallidos después de 1 minuto
                UserModel::resetFailedAttempts($username);
            }
        }
    }

    if ($user && UserModel::validatePassword($password, $user['contrasena'])) {
        UserModel::resetFailedAttempts($username); // Restablecer intentos fallidos al iniciar sesión correctamente

        // Generar un token simple
        $token = bin2hex(random_bytes(32)); // Genera un token de 64 caracteres
        $_SESSION['token'] = $token;
        $_SESSION['username'] = $username; // Guardar el nombre de usuario en la sesión

        // Guardar el token en una cookie
        setcookie('token', $token, time() + 3600, "/", "", false, true); // Cookie segura

        header("Location: welcome.php");
        exit();
    } else {
        UserModel::incrementFailedAttempts($username); // Incrementar intentos fallidos
        echo "Nombre de usuario o contraseña incorrectos.";
    }
}
?>
