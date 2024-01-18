<?php

//Incluyo funciones creadas para la conexión a la BD y el CRUD
include 'funciones.php';

//Iniciamos la sesión de usuario
session_start();

//Establecemos la conexion esta vez por medio de la función conexion.
$conexion = conexion();

//Verifica si las variables de las sesiones están establecidas. Si no está definida, se le asigna el valor null para asegurarse de que la variable exista y esté inicializada, posiblemente con solo validar una de ellas sería suficiente pero bueno en este caso he puesto las 3.
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = null;
}
if (!isset($_SESSION['pass'])) {
    $_SESSION['pass'] = null;
}
if (!isset($_SESSION['nombre_usuario'])) {
    $_SESSION['nombre_usuario'] = null;
}

//Esto declara una variable llamada $error_pass y le asigna una cadena de texto como valor.
$error_pass = '<div> 
<p>La contraseña debe cumplir con los siguientes criterios:</p>
<p>- Debe contener una combinación de letras y números.</p>
<p>- Debe incluir al menos una letra mayúscula.</p>
<p>- Debe tener entre 4 y 10 caracteres de longitud.</p>
<p>- Debe contener al menos un carácter especial como () o ,. aporrea ese teclado XD</p>
</div>';


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

        </div>
    </nav>
</header>

<body>


    <h1 align="center">REGISTRARSE</h1>
    <!--Formulario de login validado en HTML-->
    <form method='POST' readonly id="cajaFormulario" align="center">

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
            <input type="password" class="form-control" name="pass1" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Repite Contraseña</span>
            <input type="password" class="form-control" name="pass2" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$>">
        </div>
        <input type="submit" name="enviar" value="REGISTRARSE" class="btn btn-primary">

        <!--Enlace que lleva a la página de login.php para usuarios ya registrados-->
        <a href="login.php">Ya estoy registrado</a>
    </form>
    <br><br>

</body>

</html>
<?php
//Compruebo si se ha enviado el formulario por POST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    ////Verifica si se ha enviado un formulario mediante el método POST y si existe un campo llamado 'enviar'
    if (isset($_POST['enviar'])) {

        //Si se cumple esta condición, el código continúa obteniendo los valores enviados a través del formulario para las variables $email, $pass y $nombre_usuario.
        $email = $_POST['email'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $nombreUsuario = $_POST['nombre_usuario'];

        //Compruebo en PHP si el email se ha enviado y si es válido

        if (empty($email)) {

            echo 'Debes introducir un email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            echo 'Debes introducir un email correcto';

            //Si es así, compruebo si ya existe el usuario en la BD
        } else {

            $existe_usuario = buscar_usuario($conexion, $email);

            if ($existe_usuario) {

                echo "Ya existe un usuario con el email " . $email;
            } else {
                //Si no existe, valido contraseña

                if (!empty($pass1) && !empty($pass2)) {

                    //Valido y comparo las contraseñas 1 y 2
                    $contrasenia_valida = validar_contrasenia($pass1);
                    $contrasenias_iguales = comparar_contrasenias($pass1, $pass2);

                    if ($contrasenia_valida && $contrasenias_iguales) {
                        //Si la contraseña es válida y coincide se ejecuta el registro en la BD
                        //utilizando la función PASSWORD_HASH de PHP para  encriptar la contraseña

                        $hash_contrasenia = hashContrasenia($pass1);
                        crear_usuario($conexion, $email, $hash_contrasenia, $nombreUsuario);


                        //Se asignan los valores a la sesión
                        //Y se redirige a la página de la aplicación 

                        $_SESSION['email'] = $email;
                        $_SESSION['pass'] = $hash_contrasenia;
                        $_SESSION['nombre_usuario'] = $nombreUsuario;
                        

                        header('location:index.php');
                    } elseif (!$contrasenia_valida) {
                        echo $error_pass;
                    } elseif (!$contrasenias_iguales) {
                        echo 'Las contraseñas deben coincidir';
                    }
                } else {
                    echo "Debes introducir una contraseña";
                }
            }
        }
    }
}

//Cierro la conexión a la BD
$conexion = null;
