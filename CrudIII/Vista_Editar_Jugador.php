
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

<nav" class="navbar navbar-light bg-light ">
    <div class="container-fluid row justify-content-center">

        <?php

        //conexión a la base de datos
        include "Config/conexion.php";

        //Obtenemos el valor de id con la solicitud Request, [recoge POST y GET]
        $id = $_REQUEST['id'];

        //Crear una consulta para seleccionar todos los datos de la tabla 'jugadores' donde el ID coincida con el valor recibido.
        $Sql = "SELECT * FROM jugadores WHERE id = $id";

        // Ejecutar la consulta en la base de datos a través de la conexión establecida
        $resultado = $conexion->query($Sql);

        // Obtener la primera fila de resultados como un array asociativo
        $Fila = $resultado->fetch_assoc();


        ?>
        <!--esta etiqueta center es para centrar el desplegable de la calidad de los jugadores , he sido incapaz de hacerlo de otra manera -->
        <center>
            <div class="container">
                <br> 
                <h1>Editar Jugador</h1> <!-- Encabezado para editar jugador -->
                <br> 
                <!-- Formulario que envía los datos a Modelo_Editar_Jugador.php con el ID a editar y permite enviar archivos -->
                <form action="Modelo_Editar_Jugador.php?idEditar=<?php echo $Fila['id'] ?>" method="POST" enctype="multipart/form-data">
                    

                    <div class="mb-3">
                        <label>Nombre</label> <!-- Etiqueta para el nombre -->
                        <input type="text" name="nombre" value="<?php echo $Fila['nombre'] ?>">
                        <!-- Campo de entrada de texto para el nombre, con el valor predefinido obtenido de $Fila['nombre'] -->
                    </div>

                    <div class="mb-3">
                        <label>Imagen</label> <!-- Etiqueta para la imagen -->
                        <input type="file" name="imagen">
                        <!-- Campo para subir una imagen -->
                    </div>

                    <td>
                        <img width="300" height="350" src="data:image/jgp;base64,<?php echo base64_encode($Fila['imagen']) ?>" alt="">
                        <!-- Visualización de la imagen utilizando su representación en base64 -->
                    </td>

                    <select class="form-select mb-3" name="calidad">
                        <!-- Selección de calidad -->
                        <option selected><?php echo $Fila['calidad'] ?></option>
                        <!-- Opción preseleccionada con la calidad obtenida de $Fila['calidad'] -->
                        <option value="ORO UNICO">ORO UNICO</option>
                        <option value="JUGADOR DE LA SEMANA">JUGADOR DE LA SEMANA</option>
                        <option value="ORO NORMAL">ORO NORMAL</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <!-- Botón para guardar los cambios -->
                    <a href="index.php" class="btn btn-info">Volver</a>
                    <!-- Enlace para volver a la página principal -->
                </form>
            </div>

        </center>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </body>

</html>