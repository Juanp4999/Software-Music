<?php
// session_start();
// if (isset($_SESSION['id'])) {
//     header("Location: perfil.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro e Inicio de Sesión</title>
    <link rel="stylesheet" href="./CSS/vista.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap');
    </style>
</head>

<body style="">

    <div class="container-form">
        <form id="login-form" class="styled-form" method="POST" action="controlador.php">
            <h2>Iniciar Sesión</h2>
            <div class="form-row">
                <div class="form-column">
                    <label for="Correo">Correo:</label>
                    <input type="email" id="Correo" name="Correo" required>
                </div>
                <div class="form-column">
                    <label for="Contrasenia">Contraseña:</label>
                    <input type="password" id="Contrasenia" name="Contrasenia" required>
                </div>
            </div>
            <input type="submit" name="iniciarSesion" value="Iniciar Sesión">
            <div class="link">
                <p>¿No tienes cuenta? <br> <a href="#" id="show-register">Crea una aquí</a></p>
            </div>

        </form>

        <form id="register-form" class="styled-form" method="POST" action="controlador.php" style="display: none;">
            <h2>Crear Usuario</h2>
            <div class="form-row">
                <div class="form-column">
                    <label for="idUsuario">ID de Usuario:</label>
                    <input type="text" id="idUsuario" name="idUsuario" required>
                </div>
                <div class="form-column">
                    <label for="CorreoRegistro">Correo:</label>
                    <input type="email" id="CorreoRegistro" name="Correo" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="ContraseniaRegistro">Contraseña:</label>
                    <input type="password" id="ContraseniaRegistro" name="Contrasenia" required>
                </div>
                <div class="form-column">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" id="Nombre" name="Nombre" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="Apellido">Apellido:</label>
                    <input type="text" id="Apellido" name="Apellido" required>
                </div>
                <div class="form-column">
                    <label for="Edad">Edad:</label>
                    <input type="number" id="Edad" name="Edad" required>
                </div>
            </div>
            <input type="submit" name="crearUsuario" value="Crear Usuario">
            <div class="link">
                <p>¿Ya tienes cuenta? <br> <a href="#" id="show-login">Inicia sesión aquí</a></p>
            </div>

        </form>
    </div>
    <script>
        document.getElementById('show-register').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        });

        document.getElementById('show-login').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        });
    </script>
</body>

</html>