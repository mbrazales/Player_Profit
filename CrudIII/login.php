<?php
//Incluyo funciones creadas para la conexión a la BD y el CRUD
include 'funciones.php';

//Iniciamos la sesión de usuario
session_start();

//Verifica si las variables de las sesiones están establecidas. Si no está definida, se le asigna el valor null para asegurarse de que la variable exista y esté inicializada.
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = null;
}
if (!isset($_SESSION['pass'])) {
    $_SESSION['pass'] = null;
}
if (!isset($_SESSION['nombre_usuario'])) {
    $_SESSION['nombre_usuario'] = null;
}
// Lógica para iniciar sesión, por ejemplo, después de que el usuario haya ingresado las credenciales correctamente.
$_SESSION['loggedin'] = true;

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

        </div>
    </nav>
</header>

<body>
    <h1 align="center">LOGIN</h1>
    <!--Formulario de Login-->
    <form method="post" readonly id="cajaFormulario" align="center">

        <!-- utilizamos el método required para que sean obligatorios los campos-->
        <div class="input-group  mb-3">
            <span class="input-group-text">NOMBRE</span>
            <input type="text" class="form-control" name="nombre_usuario" required pattern="^[a-zA-Z._%+-]+@[a-zA-Z.-]+\.[a-zA-Z]$"><br>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">EMAIL</span>
            <input type="email" class="form-control" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">CONTRASEÑA</span>
            <input type="password" class="form-control" name="pass" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
        </div>
        <input type="submit" name="submit" value="LOGIN" class="btn btn-primary">
        <input type="reset" name="reset" value="BORRAR" class="btn btn-danger">

        <!--Enlace que lleva a la página de registro.php para usuarios nuevos-->
        <a href="Vista_Registro.php">Regístrate</a>
    </form>
    <br><br>
</body>

</html>

<?php

//establecemos la conexion
$conexion = conexion();

//Si se ha enviado el formulario y he recibido los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Verifica si se ha enviado un formulario mediante el método POST y si existe un campo llamado 'submit'
    if (isset($_POST['submit'])) {

        //Si se cumple esta condición, el código continúa obteniendo los valores enviados a través del formulario para las variables $email, $pass y $nombre_usuario.
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $nombre_usuario = $_POST['nombre_usuario'];

        //Valido si los campos de email y password están vacíos
        if (!empty($email) && !empty($pass)) {

            //Busco el usuario y el hash asociado a su contraseña
            $hash_BD = buscar_usuario_hash($conexion, $email);

            //Compruebo que la contraseña introducida coincide con el hash asignado
            $datos_validos = coincidenContrasenias($pass, $hash_BD);

            if ($datos_validos) {

                //Si existe, asigno el email y la contraseña como datos de sesión
                //Y la página redirige a la aplicación index.php

                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
                $_SESSION['nombre_usuario'] = $nombre_usuario;

                header('location:index.php');
            } else {
                //De lo contrario, lanzo un mensaje de error

                echo '¡El usuario o la contraseña no son válidos!';
            }
        } else if (empty($email) && empty($pass)) {
            echo "Por favor, introduce tu email y contraseña.";
        }
    }
}
//Cierro la conexión a la BD
$conexion = null;
?>