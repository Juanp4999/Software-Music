<?php
session_start();
include('modelo.php');

// Comprueba si la solicitud fue enviada mediante el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Registro de usuario
    if (isset($_POST['crearUsuario'])) {
        $idUsuario = $_POST['idUsuario'];
        $correo = $_POST['Correo'];
        $contrasenia = $_POST['Contrasenia']; // La contraseña ya no se encripta
        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $edad = $_POST['Edad'];

        // Llamar a la función registrarUsuario
        if (registrarUsuario($idUsuario, $correo, $contrasenia, $nombre, $apellido, $edad)) {
            echo "<script>
                    alert('El Usuario se ha Registrado correctamente');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
            exit();
        } else {
            echo "Error al registrar el usuario.";
        }
    }

    // Inicio de sesión
    if (isset($_POST['iniciarSesion'])) {
        $correo = $_POST['Correo'];
        $contrasenia = $_POST['Contrasenia'];

        // Verificar usuario y contraseña sin encriptación
        $usuario = iniciarSesion($correo, $contrasenia);
        if ($usuario) {
            $_SESSION['idUsuario'] = $usuario['idUsuario'];
            $_SESSION['Correo'] = $usuario['Correo'];
            $_SESSION['Nombre'] = $usuario['Nombre'];
            $_SESSION['Apellido'] = $usuario['Apellido'];
            $_SESSION['Contrasenia'] = $usuario['Contrasenia'];
            $_SESSION['Edad'] = $usuario['Edad'];
            // Redirigir según el rol
            if ($usuario['Rol_idRol'] == 1) {
                header("Location: ./PERFIL/Admin.php");
            } elseif ($usuario['Rol_idRol'] == 0) {
                header("Location: ./PERFIL/usuario.php");
            }
            exit();
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    }

    // Cerrar sesión
    if (isset($_POST['accion']) && $_POST['accion'] === 'cerrarSesion') {
        cerrarSesion();
    }

    // Eliminar usuario
    if (isset($_POST['eliminarUsuario'])) {
        $id = $_POST['idUsuario'];
        $resultado = eliminarUsuario($id);
        $_SESSION['mensaje'] = $resultado;

        if ($resultado) {
            echo "<script>
                    alert('El Usuario se ha eliminado correctamente');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al eliminar Usuario');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        }
        exit();
    }

    if (isset($_POST['eliminarPartitura'])) {
        $id = $_POST['idPartituras'];
        $resultado = eliminarPartitura($id);
        $_SESSION['mensaje'] = $resultado;

        if ($resultado) {
            echo "<script>
                    alert('La Partitura se ha eliminado correctamente');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al eliminar Partitura');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        }
        exit();
    }

    // Actualizar usuario
    // Actualizar usuario
    if (isset($_POST['actualizarUsuario'])) {
        $idUsuarioAc = $_POST['idUsuario'];
        $correoAc = $_POST['Correo'];
        $contraseniaAc = $_POST['Contrasenia'];
        $nombreAc = $_POST['Nombre'];
        $apellidoAc = $_POST['Apellido'];
        $edadAc = $_POST['Edad'];
        $Rol = $_POST['Rol_idRol'];

        $resultado = actualizarUsuario($idUsuarioAc, $correoAc, $contraseniaAc, $nombreAc, $apellidoAc, $edadAc, $Rol);
        $_SESSION['mensaje'] = $resultado;

        if ($resultado) {
            // Si el usuario que se está actualizando es el mismo que el que está en sesión
            if ($idUsuarioAc == $_SESSION['idUsuario']) {
                // Actualiza la sesión con los nuevos datos
                $_SESSION['Nombre'] = $nombreAc;
                $_SESSION['Apellido'] = $apellidoAc; // Opcional: actualiza también el apellido
                echo "<script>
                    alert('El Usuario se ha actualizado correctamente. Como la modificación fue a su información, deberá volver a iniciar sesión');
                    window.location.href = 'vista.php';
                  </script>";
            } else {
                echo "<script>
                    alert('El Usuario se ha actualizado correctamente');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "'; 
                  </script>";
            }
        } else {
            echo "<script>
                alert('Error al Actualizar Usuario');
                window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
              </script>";
        }
        exit();
    }

    // Mostrar usuario
    if (isset($_POST['mostrarUsuario'])) {
        $idUsuario = $_POST['idUsuario'];

        if (!$idUsuario) {
            $usuarios = mostrarUsuarios();
            $_SESSION['usuarios'] = $usuarios;

            echo "<script>
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        } else {
            $usuario = mostraUsuario($idUsuario);

            if ($usuario) {
                $_SESSION['usuarioEncontrado'] = $usuario;
            } else {
                unset($_SESSION['usuarioEncontrado']);
            }

            echo "<script>
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        }


    }

    if (isset($_POST['registrarPartitura'])) {
        $idPartituras = $_POST['idPartituras'];
        $Nombre = $_POST['Nombre'];
        $Precio = $_POST['Precio'];
        $Descripcion = $_POST['Descripcion'];
        $Usuario_idUsuario = $_POST['Usuario_idUsuario'];
    
        // Verificar si el archivo PDF fue enviado
        if (isset($_FILES['partituraPDF']) && $_FILES['partituraPDF']['error'] === UPLOAD_ERR_OK) {
            $archivoPDF = $_FILES['partituraPDF']['name'];
            
            // Mover el archivo a la carpeta "assets/pdf"
            $carpetaDestino = './Partituras/';
            $rutaArchivo = $carpetaDestino . basename($archivoPDF);
            @copy($_FILES['partituraPDF']['tmp_name'], $rutaArchivo);
            
    
            // Verificar si se pudo registrar la partitura en la base de datos
            if (registrarPartituras($idPartituras, $Nombre, $Precio, $Descripcion, $Usuario_idUsuario, $archivoPDF)) {
                echo "<script>
                const nuevaPartitura = {
                    id: '$idPartituras',
                    Usuario_idUsuario: '$Usuario_idUsuario',
                    name: '$Nombre',
                    price: '$Precio',
                    description: '$Descripcion',
                    archivoPDF: '$archivoPDF'
                };
                Patitura.Partituras.push(nuevaPartitura);
                populateProducts(Patitura);
                alert('Partitura registrada correctamente');
                </script>";
            } else {
                echo "<script>alert('Error al registrar partitura');</script>";
            }
        } else {
            echo "<script>alert('Error al subir el archivo PDF');</script>";
        }
    
        // Redireccionar después de que el script se ejecute
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    
    if (isset($_POST['mostrarPartitura'])) {
        $idPartitura = $_POST['idPartitura'];
    
        if (!$idPartitura) {
            $partituras = obtenerTodasPartituras();
            $_SESSION['partituras'] = $partituras;
    
            echo "<script>
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        } else {
            $partitura = mostrarPartitura($idPartitura);
    
            if ($partitura) {
                $_SESSION['partituraEncontrada'] = $partitura;
            } else {
                unset($_SESSION['partituraEncontrada']);
            }
    
            echo "<script>
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
        }
    }

    if (isset($_POST['modificarPartitura'])) {
        $idPartituras = $_POST['idPartituras'];
        $Nombre = $_POST['Nombre'];
        $Precio = $_POST['Precio'];
        $Descripcion = $_POST['Descripcion'];
        $Usuario_idUsuario = $_POST['Usuario_idUsuario'];
        $archivoPDF = $_FILES['partituraPDF']['name']; // Nombre del archivo subido
    
        // Actualizar la partitura en la base de datos
        $resultado = modificarPartitura($idPartituras, $Nombre, $Precio, $Descripcion, $Usuario_idUsuario, $archivoPDF);
        $_SESSION['mensaje'] = $resultado; // Guarda el resultado en la sesión para usarlo después
    
        if ($resultado) {
            // Si se ha subido un nuevo archivo PDF, maneja la subida
            if (!empty($archivoPDF)) {
                // Lógica para mover el archivo a la ubicación deseada
                move_uploaded_file($_FILES['partituraPDF']['tmp_name'], "ruta/donde/guardar/" . $archivoPDF);
            }
    
            echo "<script>
                alert('La Partitura se ha actualizado correctamente');
            </script>";
        } else {
            echo "<script>
                alert('Error al modificar partitura');
            </script>";
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
   

}
?>