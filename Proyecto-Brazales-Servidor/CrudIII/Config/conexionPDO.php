<?php
// CONEXIÓN A LA BASE DE DATOS POR PDO

// Definición de las credenciales para la conexión
$servername = "localhost"; // Nombre del servidor de la base de datos
$database = "profit"; // Nombre de la base de datos a la que se va a conectar
$username = "adefifa"; // Nombre de usuario de la base de datos
$password = "root"; // Contraseña de la base de datos

// Intenta conectar con la base de datos utilizando PDO
try {
    // Cadena de conexión PDO
    $conexionPDO = "mysql:host=$servername;dbname=$database;"; 

    // Creación de un nuevo objeto PDO para la conexión
    $miPDO = new PDO($conexionPDO, $username, $password);

    // Establece el modo de error para lanzar excepciones
    $miPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

} catch (PDOException $e) {

    // En caso de error en la conexión, muestra un mensaje de error y finaliza la ejecución del programa
    echo "No se ha conectado con la base de datos";
    
    die("Error: " . $e->getMessage());
}
?>
