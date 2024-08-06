<?php
require_once 'config.php';

class UserModel {
    public static function getUserByUsername($username) {
        $pdo = Database::connect();
        if ($pdo === null) {
            throw new Exception("No se pudo conectar a la base de datos.");
        }
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function validatePassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    public static function incrementFailedAttempts($username) {
        $pdo = Database::connect();
        if ($pdo === null) {
            throw new Exception("No se pudo conectar a la base de datos.");
        }
        $stmt = $pdo->prepare("UPDATE usuarios SET failed_attempts = failed_attempts + 1, last_failed_attempt = NOW() WHERE nombre_usuario = ?");
        $stmt->execute([$username]);
    }

    public static function resetFailedAttempts($username) {
        $pdo = Database::connect();
        if ($pdo === null) {
            throw new Exception("No se pudo conectar a la base de datos.");
        }
        $stmt = $pdo->prepare("UPDATE usuarios SET failed_attempts = 0, last_failed_attempt = NULL WHERE nombre_usuario = ?");
        $stmt->execute([$username]);
    }

    public static function getFailedAttempts($username) {
        $pdo = Database::connect();
        if ($pdo === null) {
            throw new Exception("No se pudo conectar a la base de datos.");
        }
        $stmt = $pdo->prepare("SELECT failed_attempts, last_failed_attempt FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function registerUser($username, $hashedPassword) {
        $pdo = Database::connect();
        if ($pdo === null) {
            throw new Exception("No se pudo conectar a la base de datos.");
        }
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
    }
}
?>
