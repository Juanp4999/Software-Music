<?php
include('../controlador.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../vista.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" type="text/css" href="../CSS/modal.css">
    <link rel="stylesheet" type="text/css" href="../CSS/admin.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="tittle">
        <h2>Bienvenido, <?php echo $_SESSION['Nombre']; ?>!</h2>
    </div>
    <div class="tittleB">
        <h2>En esta sección, tú tienes el control</h2>
    </div>
    <div class="nav">
        <div>
            <button class="link">
                <a href="#modal-user" style="text-decoration: none; color: black;" class="btn-abrir-modal">Crear
                    Usuario</a>
            </button>
        </div>
        <div>
            <button class="link">
                <a href="#modal-partitura" style="text-decoration: none; color: black;" class="btn-abrir-modal">Subir
                    Partitura</a>
            </button>
        </div>
        <div>
            <form method="post" action="../controlador.php">
                <input type="hidden" name="accion" value="cerrarSesion">
                <button type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <!-- Modal para crear usuario -->
    <div id="modal-user" class="modal modal-user">
        <div class="modal-contenido">
            <a href='#' class='cerrar'>×</a>
            <h2>Crear Usuario</h2>
            <form method="POST" action="../controlador.php" class="modal-form">
                <div class="input-box">
                    <label for="idUsuario">Identificación:</label>
                    <br>
                    <input type="number" name="idUsuario" required>
                </div>
                <div class="input-box">
                    <label for="nombre">Nombre:</label>
                    <br>
                    <input type="text" name="Nombre" required>
                </div>
                <div class="input-box">
                    <label for="apellido">Apellido:</label>
                    <br>
                    <input type="text" name="Apellido" required>
                </div>
                <div class="input-box">
                    <label for="edad">Edad:</label>
                    <br>
                    <input type="number" name="Edad" required>
                </div>
                <div class="input-box">
                    <label for="correo">Correo:</label>
                    <br>
                    <input type="email" name="Correo" required>
                </div>
                <div class="input-box">
                    <label for="contrasenia">Contraseña:</label>
                    <br>
                    <input type="password" name="Contrasenia" required>
                </div>
                <br>
                <button type="submit" name="crearUsuario">Crear Usuario</button>
            </form>
        </div>
    </div>
    <div id="modal-partitura" class="modal modal-user">
        <div class="modal-contenido">
            <a href='#' class='cerrar'>×</a>
            <h2>Subir Partitura</h2>
            <form method="POST" action="../controlador.php" class="modal-form" enctype="multipart/form-data">
                <div class="input-box">
                    <label for="idPartituras">Identificación:</label>
                    <br>
                    <input type="number" name="idPartituras" required>
                </div>
                <div class="input-box">
                    <label for="Nombre">Nombre:</label>
                    <br>
                    <input type="text" name="Nombre" required>
                </div>
                <div class="input-box">
                    <label for="Precio">Precio:</label>
                    <br>
                    <input type="text" name="Precio" required>
                </div>
                <div class="input-box">
                    <label for="Descripcion">Descripción:</label>
                    <br>
                    <input type="text" name="Descripcion" required>
                </div>
                <div class="input-box">
                    <label for="partituraPDF">Partitura PDF:</label>
                    <br>
                    <input type="file" id="partituraPDF" name="partituraPDF" accept="application/pdf" required>
                </div>
                <br>
                <input type="hidden" name="Usuario_idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>">

                <button type="submit" name="registrarPartitura">Registrar Partitura</button>
            </form>

        </div>
    </div>
    <div class="tittleB">
        <h2>Usuarios</h2>
    </div>
    <div class="SeccionA">
    <div class="container">
        <div class='container-buscador'>
            <input type="text" id="buscador" placeholder="Buscar...">
        </div>
        <div class='container-tabla'>
            <table id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>Correo</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Eliminar</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['usuarios'])) {
                        $usuarios = $_SESSION['usuarios'];
                    } else {
                        $usuarios = mostrarUsuarios();
                    }
                    foreach ($usuarios as $fila) {
                        echo "<tr>";
                        echo "<td>{$fila['idUsuario']}</td>";
                        echo "<td>{$fila['Nombre']}</td>";
                        echo "<td>{$fila['Apellido']}</td>";
                        echo "<td>{$fila['Edad']}</td>";
                        echo "<td>{$fila['Correo']}</td>";
                        echo "<td>{$fila['Contrasenia']}</td>";
                        echo "<td>{$fila['Rol_idRol']}</td>";
                        echo "<td>
                        <form action='../controlador.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='idUsuario' value='{$fila['idUsuario']}'>
                            <input type='hidden' name='eliminarUsuario' value='1'>
                            <button type='submit' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\");'>Eliminar</button>
                        </form>
                    </td>";
                        echo "<td>
                        <button><a href='#modal{$fila['idUsuario']}' class='btn btn-abrir-modal'>Modificar</a></button>
                        <div id='modal{$fila['idUsuario']}' class='modal'>
                            <div class='modal-contenido'>
                                <h2>Modificar Usuario</h2>
                                <a href='#' class='cerrar'>×</a>
                                <form action='../controlador.php' method='POST'>
                                    <input type='hidden' name='idUsuario' value='{$fila['idUsuario']}'>
                                    <div>
                                        <label for='Correo'>Correo:</label>
                                        <br>
                                        <input type='email' name='Correo' value='{$fila['Correo']}' required>
                                    </div>
                                    <div>
                                        <label for='Contrasenia'>Nueva Contraseña:</label>
                                        <br>
                                        <input type='password' name='Contrasenia' value='{$fila['Contrasenia']}' required>
                                    </div>
                                    <div>
                                        <label for='Nombre'>Nombre:</label>
                                        <br>
                                        <input type='text' name='Nombre' value='{$fila['Nombre']}' required>
                                    </div>
                                    <div>
                                        <label for='Apellido'>Apellido:</label>
                                        <br>
                                        <input type='text' name='Apellido' value='{$fila['Apellido']}' required>
                                    </div>
                                    <div>
                                        <label for='Edad'>Edad:</label>
                                        <br>
                                        <input type='number' name='Edad' value='{$fila['Edad']}' required>
                                    </div>
                                    <div>
                                        <input type='hidden' name='Rol_idRol' value='{$fila['Rol_idRol']}' required>
                                    </div> <br>
                                    <button type='submit' name='actualizarUsuario'>Guardar cambios</button>
                                </form>
                            </div>
                        </div>
                    </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('buscador').addEventListener('keyup', function() {
        let input = this.value.toLowerCase(); // Obtener el valor en minúsculas
        let rows = document.querySelectorAll('#tablaUsuarios tbody tr'); // Seleccionar todas las filas de la tabla

        rows.forEach(row => {
            let cells = row.getElementsByTagName('td'); // Obtener todas las celdas de la fila
            let found = false; // Variable para verificar si hay coincidencias

            // Iterar sobre las celdas de la fila
            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(input)) {
                    found = true; // Si se encuentra una coincidencia
                    break;
                }
            }

            // Mostrar u ocultar la fila dependiendo de si se encontró una coincidencia
            row.style.display = found ? '' : 'none';
        });
    });
</script>

    <div class="tittleB">
        <h2>Partituras</h2>
    </div>
    <div class="SeccionA">
    <div class="container">
    <div class='container-buscador'>
            <input type="text" id="buscadorPartituras" placeholder="Buscar...">
        </div>
        <div class='container-tabla'>
            <table id="tablaPartituras">
                <thead>
                    <tr>
                        <th>ID Partitura</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Cargador</th>
                        <th>Archivo</th>
                        <th>Eliminar</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $partituras = obtenerTodasPartituras();
                    foreach ($partituras as $partitura) {
                        echo "<tr>";
                        echo "<td>{$partitura['idPartituras']}</td>";
                        echo "<td>{$partitura['Nombre']}</td>";
                        echo "<td>{$partitura['Precio']}</td>";
                        echo "<td>{$partitura['Descripcion']}</td>";
                        echo "<td>{$partitura['Usuario_idUsuario']}</td>";
                     echo "<td>
                        <a href='../Partituras/{$partitura['archivoPDF']}' download='{$partitura['archivoPDF']}' class='btn-card'>Descargar PDF</a>
                    </td>";
                        echo "<td>
                            <form action='../controlador.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='idPartituras' value='{$partitura['idPartituras']}'>
                                <input type='hidden' name='eliminarPartitura' value='1'>
                                <button type='submit' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta partitura?\");'>Eliminar</button>
                            </form>
                        </td>";
                        echo "<td>
                            <button><a href='#modal{$partitura['idPartituras']}' class='btn btn-abrir-modal'>Modificar</a></button>
                            <div id='modal{$partitura['idPartituras']}' class='modal'>
                                <div class='modal-contenido'>
                                    <h2>Modificar Partitura</h2>
                                    <a href='#' class='cerrar'>×</a>
                                    <form action='../controlador.php' method='POST' enctype='multipart/form-data'>
                                        <input type='hidden' name='idPartituras' value='{$partitura['idPartituras']}'>
                                        <div>
                                            <label for='titulo'>Nombre:</label>
                                            <br>
                                            <input type='text' name='Nombre' value='{$partitura['Nombre']}' required>
                                        </div>
                                        <div>
                                            <label for='Precio'>Precio:</label>
                                            <br>
                                            <input type='text' name='Precio' value='{$partitura['Precio']}' required>
                                        </div>
                                        <div>
                                            <label for='Descripcion'>Descripción:</label>
                                            <br>
                                            <input type='text' name='Descripcion' value='{$partitura['Descripcion']}' required>
                                        </div>
                                        <div>
                                            <label for='Usuario_idUsuario'>Usuario ID:</label>
                                            <br>
                                            <input type='text' name='Usuario_idUsuario' value='{$partitura['Usuario_idUsuario']}' required>
                                        </div>
                                        <div>
                                            <label for='archivoPDF'>Cambiar Archivo PDF:</label>
                                            <br>
                                            <input type='file' name='partituraPDF' accept='application/pdf'>
                                        </div>
                                        <br>
                                        <button type='submit' name='modificarPartitura'>Guardar cambios</button>
                                    </form>
                                </div>
                            </div>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('buscadorPartituras').addEventListener('keyup', function() {
        let input = this.value.toLowerCase(); // Obtener el valor en minúsculas
        let rows = document.querySelectorAll('#tablaPartituras tbody tr'); // Seleccionar todas las filas de la tabla

        rows.forEach(row => {
            let cells = row.getElementsByTagName('td'); // Obtener todas las celdas de la fila
            let found = false; // Variable para verificar si hay coincidencias

            // Iterar sobre las celdas de la fila
            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(input)) {
                    found = true; // Si se encuentra una coincidencia
                    break;
                }
            }

            // Mostrar u ocultar la fila dependiendo de si se encontró una coincidencia
            row.style.display = found ? '' : 'none';
        });
    });
</script>


    <script>
        // Función para manejar el modal de creación de usuario
        const modalCrear = document.getElementById("modal-user");
        const openModalCrear = document.querySelector(".btn-abrir-modal");
        const closeModalCrear = modalCrear.querySelector(".cerrar");

        openModalCrear.addEventListener("click", function (event) {
            event.preventDefault(); // Evitar el comportamiento por defecto
            modalCrear.style.display = "flex"; // Mostrar el modal
        });

        closeModalCrear.addEventListener("click", function () {
            modalCrear.style.display = "none"; // Ocultar el modal
        });

        // Alternativamente, cerrar el modal al hacer clic fuera del contenido
        window.addEventListener("click", function (event) {
            if (event.target == modalCrear) {
                modalCrear.style.display = "none"; // Ocultar el modal
            }
        });

        // Función para manejar los modales de modificación
        const modalesModificar = document.querySelectorAll('.modal');
        modalesModificar.forEach(modal => {
            const closeBtn = modal.querySelector('.cerrar');
            const openBtn = document.querySelector(`a[href="#${modal.id}"]`);

            openBtn.addEventListener("click", function (event) {
                event.preventDefault(); // Evitar el comportamiento por defecto
                modal.style.display = "flex"; // Mostrar el modal
            });

            closeBtn.addEventListener("click", function () {
                modal.style.display = "none"; // Ocultar el modal
            });
        });

        // Alternativamente, cerrar el modal al hacer clic fuera del contenido
        window.addEventListener("click", function (event) {
            modalesModificar.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = "none"; // Ocultar el modal
                }
            });
        });

        // Función de búsqueda para Usuarios


        const modalCrearPartitura = document.getElementById("modal-partitura");
        const openModalCrearPartitura = document.querySelector(".btn-abrir-modal");
        const closeModalCrearPartitura = modalCrearPartitura.querySelector(".cerrar");

        openModalCrearPartitura.addEventListener("click", function (event) {
            event.preventDefault();
            modalCrearPartitura.style.display = "flex";
        });

        closeModalCrearPartitura.addEventListener("click", function () {
            modalCrearPartitura.style.display = "none";
        });

        window.addEventListener("click", function (event) {
            if (event.target == modalCrearPartitura) {
                modalCrearPartitura.style.display = "none";
            }
        });

        const modalesModificar = document.querySelectorAll('.modal');
        modalesModificar.forEach(modal => {
            const closeBtn = modal.querySelector('.cerrar');
            const openBtn = document.querySelector(`a[href="#${modal.id}"]`);

            openBtn.addEventListener("click", function (event) {
                event.preventDefault();
                modal.style.display = "flex";
            });

            closeBtn.addEventListener("click", function () {
                modal.style.display = "none";
            });
        });

        window.addEventListener("click", function (event) {
            modalesModificar.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        });

    




    </script>
</body>

</html>