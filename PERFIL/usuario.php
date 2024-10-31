<?php
include('../controlador.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../vista.php");
    exit;
}

$identificacion = $_SESSION['idUsuario'];
$nombre = $_SESSION['Nombre'];
$usuario = [
    'idUsuario' => $identificacion,
    'Nombre' => $nombre,
    'Correo' => $_SESSION['Correo'],
    'Contrasenia' => $_SESSION['Contrasenia'],
    'Apellido' => $_SESSION['Apellido'],
    'Edad' => $_SESSION['Edad'],
];

// Obtener las partituras del usuario
$partituras = obtenerTodasPartituras();
$partiturasJSON = json_encode($partituras);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../CSS/usuario.css">
    <link rel="stylesheet" href="../CSS/admin.css">
    <link rel="stylesheet" href="../CSS/modal.css">
</head>

<body>
    <div class="tittle">
        <h2>Bienvenido, <?php echo $nombre; ?>!</h2>
    </div>

    <div class="nav">
        <div class="contend">
            <button id="openPartituraModal">Registrar Partitura</button>
        </div>
        <div class="contend">
            <button id="openModal">Actualizar Información</button>
        </div>
        <div class="contend">
            <form method="post" action="../controlador.php">
                <input type="hidden" name="accion" value="cerrarSesion">
                <button type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <!-- Modal para actualizar información -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tú Información</h2>
            <form action="../controlador.php" method="POST">
                <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']; ?>">
                <table>
                    <tr>
                        <td><label for="Correo">Correo:</label></td>
                        <td><input type="email" name="Correo" value="<?php echo $usuario['Correo']; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="Contrasenia">Nueva Contraseña:</label></td>
                        <td><input type="password" name="Contrasenia" value="<?php echo $usuario['Contrasenia']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="Nombre">Nombre:</label></td>
                        <td><input type="text" name="Nombre" value="<?php echo $usuario['Nombre']; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="Apellido">Apellido:</label></td>
                        <td><input type="text" name="Apellido" value="<?php echo $usuario['Apellido']; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="Edad">Edad:</label></td>
                        <td><input type="number" name="Edad" value="<?php echo $usuario['Edad']; ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="actualizarUsuario">Guardar cambios</button>
                            <button type="button"
                                onclick="document.querySelector('.modal').style.display='none'">Cerrar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- Modal para registrar partitura -->
    <div id="registerPartituraModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Registrar Partitura</h2>
            <form action="../controlador.php" method="POST" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><label for="idPartituras">ID Partitura:</label></td>
                        <td><input type="text" id="idPartituras" name="idPartituras" required></td>
                    </tr>
                    <tr>
                        <td><label for="Nombre">Nombre:</label></td>
                        <td><input type="text" id="Nombre" name="Nombre" required></td>
                    </tr>
                    <tr>
                        <td><label for="Precio">Precio:</label></td>
                        <td><input type="number" id="Precio" name="Precio" required></td>
                    </tr>
                    <tr>
                        <td><label for="Descripcion">Descripción:</label></td>
                        <td><textarea id="Descripcion" name="Descripcion" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="partituraPDF">(PDF):</label></td>
                        <td><input type="file" id="partituraPDF" name="partituraPDF" accept="application/pdf" required>
                        </td>
                    </tr>
                    <input type="hidden" name="Usuario_idUsuario" value="<?php echo $usuario['idUsuario']; ?>">
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="registrarPartitura" value="Registrar Partitura">
                            <button type="button"
                                onclick="document.getElementById('registerPartituraModal').style.display='none'">Cerrar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div class="tittleB">
        <h2>Tús Obras</h2>
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
$partituras = obtenerPartituras();
foreach ($partituras as $partitura) {
    echo "<tr>";
    echo "<td>{$partitura['idPartituras']}</td>";
    echo "<td>{$partitura['Nombre']}</td>";
    echo "<td>{$partitura['Precio']}</td>";
    echo "<td>{$partitura['Descripcion']}</td>";
    echo "<td>{$partitura['Usuario_idUsuario']}</td>";
    
    // Enlace de descarga ajustado para compatibilidad
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
                        <label for='titulo'>Nombre:</label><br>
                        <input type='text' name='Nombre' value='{$partitura['Nombre']}' required>
                    </div>
                    <div>
                        <label for='Precio'>Precio:</label><br>
                        <input type='text' name='Precio' value='{$partitura['Precio']}' required>
                    </div>
                    <div>
                        <label for='Descripcion'>Descripción:</label><br>
                        <input type='text' name='Descripcion' value='{$partitura['Descripcion']}' required>
                    </div>
                    <div>
                        <label for='Usuario_idUsuario'>Usuario ID:</label><br>
                        <input type='text' name='Usuario_idUsuario' value='{$partitura['Usuario_idUsuario']}' required>
                    </div>
                    <div>
                        <label for='archivoPDF'>Cambiar Archivo PDF:</label><br>
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
        document.getElementById('buscadorPartituras').addEventListener('keyup', function () {
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
    <div class="tittleB">
        <h2>Nuestra Seccion Musical</h2>
    </div>

    <div id="productos" class="productos"></div>

    <script>
        // Modal para actualizar información
        var myModal = document.getElementById("myModal");
        var openModalBtn = document.getElementById("openModal");
        var closeModalSpan = document.getElementsByClassName("close")[0];

        openModalBtn.onclick = function () {
            myModal.style.display = "block";
        }

        closeModalSpan.onclick = function () {
            myModal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == myModal) {
                myModal.style.display = "none";
            }
        }

        // Modal para registrar partitura
        var registerModal = document.getElementById("registerPartituraModal");
        var openPartituraModalBtn = document.getElementById("openPartituraModal");
        var closePartituraModalSpan = document.getElementsByClassName("close")[1];

        openPartituraModalBtn.onclick = function () {
            registerModal.style.display = "block";
        }

        closePartituraModalSpan.onclick = function () {
            registerModal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == registerModal) {
                registerModal.style.display = "none";
            }
        }

        // Cargar datos de partituras
        let partituraData = <?php echo $partiturasJSON; ?>;
        Partitura.Partituras = partituraData; // Asignar las partituras al objeto
        populateProducts(Partitura); // Llamar a la función para poblar el contenedor
    </script>
    <script src="../partituras.js"></script>

</body>

</html>