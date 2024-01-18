
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
    <script src="JS/galeria.js"></script>
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
     
    
         <!-- Buscador-->
        <nav" class="navbar navbar-light bg-light ">
            <div class="container-fluid row justify-content-center">
                <form class="d-flex col-7 col-md-5">
                    <input class="form-control me-3" type="search" placeholder="Buscar Jugador" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </nav>
    <body>
      <hr>
        <h1>OBRAS DE ARTE DEL FÚTBOL</h1>
          <div class="card-group ">
            <div class="card">
              <video id="videoZidane" width="500" height="300" controls poster="IMG/zidane01.jpg"><source src="VIDEOS/videoZidane.mp4" type="video/mp4"></video>
              <div class="card-body">
                <h5 class="card-title">LA OCTAVA MARAVILLA</h5>
                <p class="card-text">Cuando le preguntaron a Zidane por este gol con la zurda, el respondió que es diestro.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">Menos mal que la zurda no es su pierna buena.</small>
              </div>
            </div>
            <div class="card">
              <video id="videoRony" width="500" height="300" controls poster="IMG/rony.jpg"><source src="VIDEOS/ronaldinho.mp4" type="video/mp4"></video>
              <div class="card-body">
                <h5 class="card-title">EL PRIMER DISPARO DEL GAUCHO</h5>
                <p class="card-text">Es el jugador con más fantasia que han visto mis ojos, este video representa su llegada a la Liga.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">Se te ponen los pelos de punta al rememorarlo.</small>
              </div>
            </div>
            <div class="card">
              <video id="videoFifa" width="500" height="300" controls poster="IMG/fifa01.jpg"><source src="VIDEOS/adefifa.mp4" type="video/mp4"></video>
              <div class="card-body">
                <h5 class="card-title">BRAZALES EN FIFA</h5>
                <p class="card-text">Tras 15 años jugando sigo siendo un poco manco, pero me sigue flipando este juego.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">A veces me quito los guantes del horno y hago cositas.</small>
              </div>
            </div>
          
          <script>
              document.addEventListener("DOMContentLoaded", function() {
                var video1 = document.getElementById("videoZidane");
                var video2 = document.getElementById("videoRony");
                
                video1.volume = 0.5; // Establece el volumen del primer video al 50%
                video2.volume = 0.2; // Establece el volumen del segundo video al 50%
              });
            </script>
      



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body> 
</html>