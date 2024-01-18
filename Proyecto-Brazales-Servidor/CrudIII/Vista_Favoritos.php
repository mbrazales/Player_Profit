<?php
session_start();

if (!empty($_SESSION['email']) && !empty($_SESSION['pass'])) {
    // Si hay una sesión activa, mostrar la bienvenida y el nombre de usuario
    if (isset($_SESSION['nombre_usuario'])) {
        $nombreUsuario = $_SESSION['nombre_usuario'];
        echo '<div><p>Sesión iniciada por : ' . $nombreUsuario . '</p></div>';
    } else {
        // Si no hay nombre de usuario en la sesión, mostrar un mensaje genérico
        echo '<div><p>¡Bienvenido!</p></div>';
    }
} else {
    // Si no hay sesión activa, redirigir a la página de inicio de sesión
    header('location:login.php');
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // El usuario ha iniciado sesión
    echo 'El usuario ha iniciado sesión.</br>';
} else {
    // El usuario no ha iniciado sesión
    echo 'El usuario no ha iniciado sesión.';
}

if (!empty($_SESSION['nombre_usuario'])) {
    $nombreUsuario = $_SESSION['nombre_usuario'];

    // Crear una cookie con el nombre de usuario
    setcookie('nombre_usuario_cookie', $nombreUsuario, time() + (86400 * 30), '/'); // Cookie válida por 30 días

    echo "Se ha creado una cookie con el nombre de usuario: $nombreUsuario";
} else {
    echo "No hay un nombre de usuario en la sesión.";
}

?>


<!-- Botón para cerrar la sesión de usuario-->

<form method="post">
    <input type="submit" name="logout" value="CERRAR SESIÓN" class="boton">
</form>



<?php

//Si se envía el formulario de cerrar sesión de usuario
//Se destruye la sesión y se redirige a la página de login.php

// Cierre de sesión y eliminación de la cookie de favoritos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        // Eliminar la cookie de jugadores favoritos
        setcookie('favoritos', '', time() - 3600, '/'); // Caducar la cookie

        // Mensaje de depuración
        echo "Cookie 'favoritos' eliminada.";

        session_destroy();
        header('location: Vista_Registro.php');
        exit();
    }
}


?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Proyecto</title>
</head>

<header class="bg-secondary">

    <!-- Inicio del menu -->

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- icono o nombre -->

            <a class="navbar-brand" href="index.php">
                <i class="bi bi-suit-spade-fill"></i>
                <span class="text-success">PLAYER PROFIT</span>
            </a>

            <!-- boton del menu -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- elementos del menu colapsable -->

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="paginaBase.php">Mercado</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Jugadores
                        </a>

                        <ul class="dropdown-menu bg-success" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Listado de jugadores</a></li>
                            <li><a class="dropdown-item" href="galeria.html">Jugadores de la semana</a>
                            <li>
                            <li><a class="dropdown-item" href="/CRUDjugadores/ObrasMaestras.html">Obras de arte</a></li>
                        </ul>
                    </li>
                </ul>

                <hr class="d-md-none text-white-50">

                <!-- enlaces redes sociales -->

                <ul class="navbar-nav  flex-row flex-wrap text-light">

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-twitter"></i>
                        <small class="d-md-none ms-2">Twitter</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-github"></i>
                        <small class="d-md-none ms-2">GitHub</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-whatsapp"></i>
                        <small class="d-md-none ms-2">WhatsApp</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-facebook"></i>
                        <small class="d-md-none ms-2">Facebook</small>
                    </li>

                </ul>

                <!--boton Informacion -->

                <form class="d-flex">
                    <a href="Registro.php">
                        <button type="button" class="btn btn-outline-success">INICIO DE SESIÓN</button>
                    </a>
                </form>


            </div>

        </div>
    </nav>
</header>

<body>
<?php
    // Incluye el archivo de conexión a la base de datos mediante PDO
    include 'Config/conexionPDO.php';

    // Obtiene el nombre de usuario de la sesión
    $nombre_usuario = $_SESSION['nombre_usuario'];

    // Verifica si existe una lista de jugadores favoritos en la sesión o en una cookie
    if (!empty($_SESSION['favoritos'])) {

        // Si existe en la sesión, asigna los jugadores favoritos a la variable correspondiente
        $jugadores_favoritos = $_SESSION['favoritos'];

    } elseif (isset($_COOKIE['favoritos' . $nombre_usuario])) {

        // Si no existe en la sesión pero sí en una cookie, deserializa y asigna los jugadores favoritos a la variable correspondiente
        $jugadores_favoritos = unserialize($_COOKIE['favoritos' . $nombre_usuario]);
    }



// Verificar si la cookie de favoritos existe
if (isset($_COOKIE['favoritos'])) {

    $favoritos = unserialize($_COOKIE['favoritos']); // Obtener la lista de favoritos desde la cookie

    if (!empty($favoritos)) {

        try {
            // Consultar la base de datos para obtener la información de los jugadores favoritos

            $in = str_repeat('?,', count($favoritos) - 1) . '?'; // Crear una cadena de comodines para la consulta SQL

            $sql = "SELECT * FROM jugadores WHERE id IN ($in)"; // Consulta SQL para obtener los jugadores por sus IDs

            $statement = $miPDO->prepare($sql); // Preparar la consulta

            $statement->execute($favoritos); // Ejecutar la consulta con los IDs de los jugadores

            $jugadores_favoritos = $statement->fetchAll(PDO::FETCH_ASSOC); // Obtener los jugadores como un array asociativo

            if ($jugadores_favoritos) {
                
                // Mostrar la información de los jugadores favoritos
                echo "<h1>Jugadores Favoritos</h1>";
                echo "<table class='table'>";
                echo "<thead>
                        <tr>
                            <th scope='col'>JUGADOR</th>
                        </tr>
                    </thead>";
                echo "<tbody>";

                foreach ($jugadores_favoritos as $jugador) {

                    // Mostrar la información de cada jugador
                    echo "<tr>";
                    echo "<td><img width='150' height='200' src='data:image/jpg;base64," . base64_encode($jugador['imagen']) . "' alt=''></td>"; // Mostrar la imagen del jugador
                    echo "<td>" . $jugador['nombre'] . "</td>"; // Mostrar el nombre del jugador
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No se encontraron jugadores favoritos"; // Mensaje si no se encuentran jugadores favoritos
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage(); // Manejar errores de consulta
        }
    } else {
        echo "No hay jugadores marcados como favoritos"; // Mensaje si no hay jugadores marcados como favoritos
    }
} else {
    echo "No hay jugadores marcados como favoritos"; // Mensaje si la cookie de favoritos no existe
}



    // ... Tu código para mostrar la lista de favoritos ...

    echo "<form method='post' action='Controlador_EliminarFavoritos.php'>";
    echo "<input type='submit' name='eliminar_favoritos' value='Eliminar Todos los Favoritos' class='btn btn-danger'>";

    echo "</form>";
    ?>
    <a href="index.php" class="btn btn-Warning">Volver</a>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<footer>
    <header class="bg-secondary">

        <!-- Inicio del menu -->

        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
                <!-- icono o nombre -->

                <a class="navbar-brand" href="index.php">
                    <i class="bi bi-suit-spade-fill"></i>
                    <span class="">@BRAZALES TEAM</span><i class="bi bi-suit-spade-fill"></i>
                </a>
                <i class="bi bi-suit-spade-fill"></i>
                <a class="navbar-brand" href="index.php">
                    <i class="cookies"></i>
                    <span class="text-success">PLAYER PROFIT</span>
                </a>



                <!-- enlaces redes sociales -->

                <ul class="navbar-nav  flex-row flex-wrap text-light">

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-twitter"></i>
                        <small class="d-md-none ms-2">Twitter</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-github"></i>
                        <small class="d-md-none ms-2">GitHub</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-whatsapp"></i>
                        <small class="d-md-none ms-2">WhatsApp</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-facebook"></i>
                        <small class="d-md-none ms-2">Facebook</small>
                    </li>

                </ul>

                <!--boton Informacion -->

                <form class="d-flex">
                    <a href="Vista_Contacto.php">
                        <button type="button" class="btn btn-outline-info">CONTACTO</button>
                    </a>
                </form>


            </div>

            </div>
        </nav>
</footer>

</html>