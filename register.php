<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .error { color: red; }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-group input:focus {
            border-color: #80bdff;
            outline: none;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 400;
            text-align: center;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Registro</h2>
        <form id="registrationForm" action="register_process.php" method="post">
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" 
                       pattern="[A-Za-z0-9_]{5,20}" 
                       title="El nombre de usuario debe tener entre 5 y 20 caracteres y puede contener letras, números y guiones bajos." 
                       required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" 
                       pattern=".{8,}" 
                       title="La contraseña debe tener al menos 8 caracteres." 
                       required>
            </div>
            <button type="submit" class="btn">Registrar</button>
        </form>
        <div class="text-center">
            <p>¿Ya tienes una cuenta? <a href="login.php" class="btn">Iniciar Sesión</a></p>
        </div>
    </div>
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var errors = [];

            // Validar nombre de usuario
            if (!/^[A-Za-z0-9_]{5,20}$/.test(username)) {
                errors.push("El nombre de usuario debe tener entre 5 y 20 caracteres y puede contener letras, números y guiones bajos.");
            }

            // Validar contraseña
            if (password.length < 8) {
                errors.push("La contraseña debe tener al menos 8 caracteres.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
