<?php


//Inicio la sesión
session_start();


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
                            <a class="nav-link" href="paginaBase.php">Mercado</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Jugadores</a>

                            <ul class="dropdown-menu bg-success" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Listado de jugadores</a></li>
                                <li><a class="dropdown-item" href="galeria.html">Jugadores de la semana</a><li>
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
                        <a href="Vista_Registro.php">
                            <button type="button" class="btn btn-outline-success">INICIO DE SESIÓN</button>
                        </a>
                    </form>


                </div>

            </div>
        </nav>
    </header>

    <body>
        <!-- Contenedor principal -->
        <div>
            <!-- Título centrado para agregar un nuevo jugador -->
            <h1 align="center" id="nuevoJugador">NUEVO JUGADOR</h1>
        </div>

        <!-- Formulario para agregar un jugador -->

        <form action="Modelo_AgregarJugador.php" method="POST" class="contenedor_incluir_jugador" enctype="multipart/form-data">

            <!-- Campo para ingresar el nombre del jugador -->
            <div class="mb-3">
                <label class="form-label">NOMBRE DEL JUGADOR :</label>
                <input type="text" class="form-control" name="nombre">
            </div>
            <!-- Campo para cargar la foto del jugador -->
            <div class="mb-3">
                <label class="form-label">FOTO : </label>
                <input type="file" class="form-control" name="imagen">
            </div>

            <!-- Selección de la calidad del jugador -->
            <select class="form-select mb-3 form-control" name="calidad">
                <option selected disabled>Elige Calidad</option>
                
                <?php
                // Incluir el archivo de conexión a la base de datos
                include "Config/conexion.php";

                // Preparar la consulta para seleccionar todos los datos de la tabla 'jugadores'
                $sql = $conexion->query("SELECT * FROM jugadores");

                // Ejecutar la consulta y mostrar los resultados
                while ($resultado = $sql->fetch_assoc()) {
                            
                    echo "<opcion value='".$resultado['id']."'>".$resultado['calidad']."</option>";
                } 

            ?>
            <option value="ORO UNICO">ORO UNICO</option>
            <option value="JUGADOR DE LA SEMANA">JUGADOR DE LA SEMANA</option>
            <option value="ORO NORMAL">ORO NORMAL</option>
        </select>

            <!-- Botón para guardar el formulario -->
            <button type="submit" class="btn btn-primary">Guardar</button>

            <!-- Enlace para volver a la página principal -->
            <a href="index.php" class="btn btn-info">Volver</a>

        </form>

        <!-- Scripts necesarios de Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>


</html>