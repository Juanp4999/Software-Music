<?php

function abrirConexion()
{
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $basedatos = "corosb";

    $conexion = mysqli_connect($servidor, $usuario, $clave, $basedatos);

    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    return $conexion;
}

function registrarUsuario($idUsuario, $correo, $contrasenia, $nombre, $apellido, $edad)
{
    $conexion = abrirConexion();

    // La contraseña no se encripta, se guarda directamente
    $consulta = "INSERT INTO usuario (idUsuario, Correo, Contrasenia, Nombre, Apellido, Edad) 
                 VALUES ('$idUsuario', '$correo', '$contrasenia', '$nombre', '$apellido', '$edad')";

    if (mysqli_query($conexion, $consulta)) {
        mysqli_close($conexion);
        return true;
    } else {
        mysqli_close($conexion);
        return false;
    }
}

function iniciarSesion($Correo, $contrasenia)
{
    $conexion = abrirConexion();
    $consulta = "SELECT idUsuario, Nombre, Correo, Contrasenia, Rol_idRol, Apellido, Edad FROM usuario WHERE Correo='$Correo'";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    // Comprobar si el usuario existe y si la contraseña coincide (sin encriptación)
    if ($fila && $contrasenia === $fila['Contrasenia']) {
        mysqli_close($conexion);
        return $fila;
    }

    mysqli_close($conexion);
    return false;
}

function cerrarSesion()
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: vista.php");
    exit();
}

function mostrarUsuarios()
{
    $conexion = abrirConexion();
    $consulta = "SELECT * FROM usuario";
    $resultado = $conexion->query($consulta);
    $usuarios = [];

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }
    }

    mysqli_close($conexion);
    return $usuarios;
}

function mostraUsuario($id)
{
    $conexion = abrirConexion();
    $consulta = "SELECT * FROM usuario WHERE idUsuario = '$id'";
    $resultado = $conexion->query($consulta);

    mysqli_close($conexion);

    if ($resultado) {
        return $resultado->fetch_assoc();
    }

    return null;
}




function actualizarUsuario($idUsuario, $correo, $contrasenia, $nombre, $apellido, $edad, $Rol)
{
    $conexion = abrirConexion();
    $consulta = "UPDATE usuario 
                 SET Correo = '$correo', 
                     Contrasenia = '$contrasenia', 
                     Nombre = '$nombre', 
                     Apellido = '$apellido', 
                     Edad = '$edad', 
                     Rol_idRol = '$Rol'
                 WHERE idUsuario = '$idUsuario'";

    if ($conexion->query($consulta)) {
        mysqli_close($conexion);
        return true;
    } else {
        mysqli_close($conexion);
        return false;
    }
}

function eliminarUsuario($idUsuario)
{
    $conexion = abrirConexion();
    $consulta = "DELETE FROM usuario WHERE idUsuario = '$idUsuario'";

    if ($conexion->query($consulta)) {
        mysqli_close($conexion);
        return true;
    }

    mysqli_close($conexion);
    return "Error al eliminar el usuario: " . $conexion->error;
}


function eliminarPartitura($id)
{
    $conexion = abrirConexion();
    $consulta = "DELETE FROM partituras WHERE idPartituras = '$id'";

    if ($conexion->query($consulta)) {
        mysqli_close($conexion);
        return true;
    }

    mysqli_close($conexion);
    return "Error al eliminar el usuario: " . $conexion->error;
}
function registrarPartituras($idPartituras, $Nombre, $Precio, $Descripcion, $Usuario_idUsuario, $archivoPDF) {
    $conexion = abrirConexion();
    $consulta = "INSERT INTO partituras (idPartituras, Nombre, Precio, Descripcion, Usuario_idUsuario, archivoPDF) 
                 VALUES ('$idPartituras', '$Nombre', '$Precio', '$Descripcion', '$Usuario_idUsuario', '$archivoPDF')";

    if (mysqli_query($conexion, $consulta)) {
        mysqli_close($conexion);
        return true;
    } else {
        mysqli_close($conexion);
        return false;
    }
}



function obtenerTodasPartituras() {
    $conexion = abrirConexion(); // Llama a la función para abrir la conexión a la base de datos

    // Prepara la consulta para obtener las partituras del usuario
    $consulta = "SELECT * FROM partituras" ;
    $resultado = mysqli_query($conexion, $consulta);
    $partituras = [];

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $partituras[] = $fila; 
        }
    }

    mysqli_close($conexion); // Cierra la conexión a la base de datos
    return $partituras; // Retorna el array con las partituras del usuario
}


// function obtenerArchivosPartitura() {
//     $conexion = abrirConexion(); // Conectar a la base de datos
//     $consulta = "SELECT archivoPDF FROM partituras";
//     $resultado = mysqli_query($conexion, $consulta);
//     $partituras = [];

//     if ($resultado && mysqli_num_rows($resultado) > 0) {
//         while ($fila = mysqli_fetch_assoc($resultado)) {
//             $partituras[] = $fila;
//         }
//     }

//     mysqli_close($conexion); // Cierra la conexión
//     return $partituras;
// }
function obtenerPartituras() {
    $conexion = abrirConexion(); // Abre la conexión a la base de datos

    $usuarioId = $_SESSION['idUsuario']; // Obtén el ID del usuario de la sesión

    // Prepara la consulta para obtener las partituras del usuario
    $consulta = "SELECT * FROM partituras WHERE Usuario_idUsuario = '$usuarioId'";
    $resultado = mysqli_query($conexion, $consulta);
    $partituras = [];

    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $partituras[] = $fila; // Agrega cada fila de resultados al array
        }
    }

    mysqli_close($conexion); // Cierra la conexión a la base de datos
    return $partituras; // Retorna el array con las partituras del usuario
}

function mostrarPartitura($idPartitura)
{
    $conexion = abrirConexion();
    $consulta = "SELECT * FROM partituras WHERE idPartituras = '$idPartitura'";
    $resultado = $conexion->query($consulta);

    mysqli_close($conexion);

    if ($resultado) {
        return $resultado->fetch_assoc();
    }

    return null;
}

function modificarPartitura($idPartituras, $Nombre, $Precio, $Descripcion, $Usuario_idUsuario, $archivoPDF)
{
    $conexion = abrirConexion();
    $consulta = "UPDATE partituras 
                 SET Nombre = '$Nombre', 
                     Precio = '$Precio', 
                     Descripcion = '$Descripcion', 
                     Usuario_idUsuario = '$Usuario_idUsuario', 
                     archivoPDF = '$archivoPDF' 
                 WHERE idPartituras = '$idPartituras'";

    if ($conexion->query($consulta)) {
        mysqli_close($conexion);
        return true;
    } else {
        mysqli_close($conexion);
        return false;
    }
}
?>