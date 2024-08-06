<?php
session_start();
require_once 'config.php';
require_once 'UserModel.php';

// Verificar que se haya enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar el nombre de usuario y la contraseña en el servidor
    if (!preg_match('/^[A-Za-z0-9_]{5,20}$/', $username)) {
        echo "El nombre de usuario debe tener entre 5 y 20 caracteres y puede contener letras, números y guiones bajos.";
        exit();
    }

    if (strlen($password) < 8) {
        echo "La contraseña debe tener al menos 8 caracteres.";
        exit();
    }

    // Verificar si el nombre de usuario ya existe
    $existingUser = UserModel::getUserByUsername($username);
    if ($existingUser) {
        echo "El nombre de usuario ya está en uso.";
        exit();
    }

    // Encriptar la contraseña antes de almacenarla
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    UserModel::registerUser($username, $hashedPassword);

    echo "Registro exitoso. Puedes <a href='login.php'>iniciar sesión</a>.";
}
?>
