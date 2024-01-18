

<?php

//Función de conexión a BD usuarios en PDO. Retorna la conexión si todo va bien
function conexion()
{

    try {

        //Datos para la conexión

        $dsn = 'mysql:host=localhost;dbname=profit';
        $usuario = 'adefifa';
        $contrasenia = 'root';

        //Creo la conexión con un nuevo objeto de PDO y los datos de conexión
        $conexion = new PDO($dsn, $usuario, $contrasenia);

        //Le indico con el atributo ATTR_ERRMODE que si hay algún error en la conexión 
        //salte un error con ERRMODE_EXCEPTION
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Si todo va bien, retorna la conexion
        return $conexion;

        //Capturo la excepción en caso de error y muestro el mensaje
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessagE();
    }
}

//Función para buscar un usuario con contraseña. 
//Toma por parámetro la conexión, el email del usuario y la contraseña. Devuelve un boolean

function buscar_usuario_hash($conexion, $usuario)
{
    try {

        //1. Prepara la consulta
        $sql = 'SELECT * FROM usuarios WHERE email=:email';
        $consulta = $conexion->prepare($sql);
        //2. Une los parámetros
        $consulta->bindParam(':email', $usuario);
        //3. Ejecuta la consulta
        $consulta->execute();
        //4. Retorna el hash de contraseña del usuario buscado
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
            return $row['contrasenia'];
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//Función para buscar si existe ya un usuario en la BD. Devuelve boolean
function buscar_usuario($conexion, $usuario)
{
    try {

        //1. Prepara la consulta
        $sql = 'SELECT * FROM usuarios WHERE email=:email;';
        $consulta = $conexion->prepare($sql);
        //2. Une los parámetros
        $consulta->bindParam(':email', $usuario);
        //3. Ejecuta la consulta
        $consulta->execute();
        //4. Verifico si hay resultados
        if ($consulta->rowCount() > 0) {
            return true; // La combinación email+pass existe en la BD
        } else {
            return false; // La combinación email+pass existe en la BD
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


//Función para registrar nuevo usuario a la BD usuarios. 
//Toma por parámetro la conexión, el email y la contraseña previamente validados
function crear_usuario($conexion, $email, $contrasenia, $nombre_usuario)
{

    try {
        //1. Prepara la consulta
        $sql = 'INSERT INTO usuarios(email, contrasenia, nombre_usuario) VALUES (:email,:pass,:nombre_usuario);';
        $consulta = $conexion->prepare($sql);

        //2. Une los parámetros
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':pass', $contrasenia);
        $consulta->bindParam(':nombre_usuario', $nombre_usuario);

        //3. Ejecuta la consulta
        $consulta->execute();

        //Capturo el error y muestro el mensaje en caso de ejecución fallida
    } catch (PDOException $e) {

        echo 'Error: ' . $e->getMessage();
    }
}

//Función para validar contraseña
//Verifica si contiene letras, números, al menos una mayúscula y un caracter especial
function validar_contrasenia($pass)
{
    //Comprueba si la contraseña tiene entre 8 y 10 caracteres (ambos incluidos)
    if (strlen($pass) < 4 || strlen($pass) > 10) {

        return false;
    }
    //Comprueba si la contraseña contiene letras
    if (!preg_match('/[A-Z]/', $pass)) {
        return false;
    }
    //Comprueba si tiene números
    if (!preg_match('/[0-9]/', $pass)) {
        return false;
    }

    //Comprueba si tiene al menos un caracter especial de la lista
    if (!preg_match('/[\.\_\-\^\(\)\#\!]/', $pass)) {
        return false;
    }

    //Si las condiciones anteriores se cumplen, retorna true
    return true;
}

//Función para comprobar si las contraseñas introducidas coinciden

function comparar_contrasenias($pass1, $pass2)
{
    if ($pass1 === $pass2) {
        return true;
    } else {
        return false;
    }
}

//Función para generar un hash para la contraseña del usuario
//y ofrecer mayor seguridad 
function hashContrasenia($contrasenia)
{
    return password_hash($contrasenia, PASSWORD_BCRYPT);
}

//Función para verificar que el hash generado y la contraseña que le corresponden
function coincidenContrasenias($contrasenia, $contraseniaBD)
{
    return password_verify($contrasenia, $contraseniaBD);
}
