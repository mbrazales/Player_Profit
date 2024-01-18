
<?php

// Session_start() para el inicio de sesión, de lo contrario si no lo hizo se le envia a la página de Vista_Registro.php, aquí nadie se cuela jajajaja.

session_start();

include "Config/conexion.php";

if (!empty($_SESSION['email']) && !empty($_SESSION['pass'])) {

    // Si hay una sesión activa, mostrar la bienvenida y el nombre de usuario y el email, realmente es para un control de las sesiones
    if (isset($_SESSION['nombre_usuario'])) {
        
        $nombreUsuario = $_SESSION['nombre_usuario'];
        $email = $_SESSION['email'];
        echo '<div><p>Sesión iniciada por : ' . $nombreUsuario . '</p></div>';
        echo '<div><p>Email : ' . $email . '</p></div>';
    } else {
        // de lo contrario mensaje de Bienvenido sin mas, aunque si nos muestra este mensaje algo está mal
        echo '<div><p>¡Bienvenido!, pero tenemos un error en algún lado</p></div>';
    }
} else {
    // Si no hay sesión activa, redirigir a la página de inicio de sesión
    header('location:login.php');
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // El usuario ha iniciado sesión
    echo 'El usuario ha iniciado sesión.';
} else {
    // El usuario no ha iniciado sesión
    echo 'El usuario no ha iniciado sesión.';
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

        // Mensaje de depuración (Realmente este mensaje nunca lo veo, en un futuro cuando aprenda hacer ventanas emergentes o algo parecido
        // daré más información a los usuarios de mi aplicación.)
        echo "Cookie 'favoritos' eliminada.";

        session_destroy();
        header('location: Vista_Registro.php');
        exit();
    }
}

?>

<!--*******************************************************************-->

<!doctype html>
<html lang="es">
<!--Head con enlaces a CSS, BOOTSTRAP Y JAVASCRIPT  -->

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Proyecto</title>
</head>

<!--Header-->
<header class="bg-secondary">

    <!-- Inicio del menu -->

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- icono-->

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
                        <a class="nav-link" href="Vista_Favoritos.php">Favoritos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Jugadores
                        </a>

                        <ul class="dropdown-menu bg-success" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="Vista_BuscarJugadores.php">Buscar Jugadores</a></li>
                            <li><a class="dropdown-item" href="Vista_Galeria.php">Galeria</a>
                            <li>
                            <li><a class="dropdown-item" href="Vista_ObrasMaestras.php">Obras de arte</a></li>
                        </ul>
                    </li>
                </ul>

                <hr class="d-md-none text-white-50">

                <!-- enlaces redes sociales PARA UN FUTURO Y SEGUIR ESCALANDO EN EL PROYECTO-->

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
                    <a href="login.php">
                        <button type="button" class="btn btn-outline-success">INICIO DE SESIÓN</button>
                    </a>
                </form>


            </div>

        </div>
    </nav>
</header>

<body>
    <h1 align="center">LISTADO DE JUGADORES</h1>

    <!-- Formulario de búsqueda -->
    <nav" class="navbar navbar-light bg-light ">
        <div class="container-fluid row justify-content-center">

        <!--La función $_SERVER["PHP_SELF"] devuelve el nombre del archivo del script que está siendo ejecutado. La función "htmlspecialchars()" se utiliza para convertir caracteres especiales en entidades HTML, lo que ayuda a prevenir posibles ataques de inyección de código-->

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="d-flex col-7 col-md-5">
                <input type="text" id="nombre" name="nombre" placeholder="Buscar por nombre">
                <button type="submit" class="btn btn-outline-success">Buscar</button>

                <!-- este boton es crucial porque al darlo el usuario resetea la busqueda y se dirige a la página principal mostrando
                    a todos los jugadores, por eso tenemos 2 codigos casi identicos uno para las busquedas y otro para mostrar a todos los jugadores,
                    he de decir que he intentado hacerlo es un solo código pero no he sabido hacerlo, en próximas entregas seguiremos intentandolo-->
                <a href="index.php" class="btn btn-default">Reset</a>
            </form>
        </div>
        </nav>
        <div class="container-fluid row justify-content-center">

            <!-- Boton para agregar un nuevo jugador -->
            <a href="Vista_NuevoJugador.php" class="btn btn-dark" id="boton-agregar">Nuevo jugador</a>
        </div>
        <hr>
        <hr>
        <!--Creación de la tabla de los jugadores, con sus respectivas columnas -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">JUGADOR</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">CALIDAD</th>
                    <th scope="col">ID</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>

            <?php

            //ESTE APARTADO ES PARA LA BUSQUEDA DE JUGADORES POR GET Y NO POR POST

            //incluimos la conexión esta vez por PDO
            include "Config/conexionPDO.php";

            // Si se envió un nombre para buscar, realizar la búsqueda
            if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {

                // Almacenamos el nombre buscado
                $nombre_buscado = $_GET['nombre'];

                try {

                    // Preparamos la consulta SQL para buscar jugadores por nombre
                    $sql = "SELECT * FROM jugadores WHERE nombre LIKE :nombre";
                    $statement = $miPDO->prepare($sql);

                    // Se usa bindValue para evitar SQL injection
                    $statement->bindValue(':nombre', '%' . $nombre_buscado . '%');

                    // Ejecutamos la consulta
                    $statement->execute();

                    // Obtenemos todos los jugadores que coinciden con la búsqueda
                    $jugadores = $statement->fetchAll(PDO::FETCH_ASSOC);

                    // Si se encontraron jugadores, mostrar información
                    if ($jugadores) {

                        //El bucle foreach se utiliza para recorrer arrays en PHP. La estructura básica es foreach ($array as $valor)
                        foreach ($jugadores as $fila) {

                            // Mostrar los detalles de los jugadores en una tabla 
                            echo "<tr>";
                            // Esto es para cargar la foto.
                            echo "<td><img width='150' height='200' src='data:image/jpg;base64," . base64_encode($fila['imagen']) . "' alt=''></td>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo "<td>" . $fila['calidad'] . "</td>";
                            echo "<td>" . $fila['id'] . "</td>";
                            echo "<td>";

                            // Botones de acción para editar, eliminar y marcar como favorito
                            echo "<a href='Vista_Editar_Jugador.php?id=" . $fila["id"] . "' class='btn btn-warning'>Editar</a>";
                            echo "<a href='Modelo_Eliminar_Jugador.php?id=" . $fila["id"] . "' class='btn btn-danger'>Eliminar</a>";

                            // El boton de favorito agrega los jugadores en una lista de favoritos por medio de una cookie para cada uno de los 
                            // distintos usuarios.
                            echo "<a href='Vista_Favoritos.php?id=" . $fila["id"] . "' class='btn btn-danger'>Favorito</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Mostrar un mensaje si no se encontraron jugadores con el nombre buscado
                        echo "<tr><td colspan='5'>No se encontraron jugadores con ese nombre.</td></tr>";
                    }
                } catch (PDOException $e) {

                    // Capturar y mostrar errores de PDO
                    echo "Error: " . $e->getMessage();
                }
            } else {

                //Siempre que vamos a index.php se muestras todos los jugadores.

                ///*******EN ESTE TRAMO NO COMENTO NADA PORQUE ES LO MISMO QUE EL CODIGO DE ARRIBA PERO ESTA VEZ MUESTRA SIEMPRE 
                ///*******LA LISTA COMPLETA DE JUGADORES ********/

                // Si no se realizó una búsqueda, mostrar todos los jugadores
                try {
                    $sql = "SELECT * FROM jugadores";
                    $statement = $miPDO->prepare($sql);
                    $statement->execute();
                    $jugadores = $statement->fetchAll(PDO::FETCH_ASSOC);

                    if ($jugadores) {
                        foreach ($jugadores as $fila) {
                            echo "<tr>";
                            echo "<td><img width='150' height='200' src='data:image/jpg;base64," . base64_encode($fila['imagen']) . "' alt=''></td>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo "<td>" . $fila['calidad'] . "</td>";
                            echo "<td>" . $fila['id'] . "</td>";
                            echo "<td>";
                            echo "<a href='Vista_Editar_Jugador.php?id=" . $fila["id"] . "' class='btn btn-warning'>Editar</a>";
                            echo "<a href='Modelo_Eliminar_Jugador.php?id=" . $fila["id"] . "' class='btn btn-danger'>Eliminar</a>";
                            echo "<a href='Controlador_Favoritos.php?id=" . $fila["id"] . "' class='btn btn-info'>Favorito</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay jugadores</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            ?>

        </table>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<footer>
    <header class="bg-secondary">

        <!-- Inicio del menu -->

        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
                <!-- icono-->

                <a class="navbar-brand" href="index.php">
                    <i class="bi bi-suit-spade-fill"></i>
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

                <!--boton CONTACTO PARA UN FORMULARIO QUE EN UN FUTURO LE DAREMOS USO-->

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