<?php

// Incluye el archivo de conexión a la base de datos
include 'Config/conexionPDO.php';

try {
    // Establece la conexión a la base de datos usando PDO
    $base = new PDO('mysql:host=localhost;dbname=profit', 'adefifa', 'root');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtiene los datos del formulario usando $_POST
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $nombre_usuario = $_POST['nombre_usuario'];


    // Prepara la consulta SQL para seleccionar datos de la tabla 'usuarios'
    $sql = 'SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password AND nombre_usuario = :nombre_usuario';
    $resultado = $base->prepare($sql);

    // Vincula los parámetros de la consulta a los valores recibidos del formulario
    $resultado->bindValue(':usuario', $usuario);
    $resultado->bindValue(':password', $password);
    $resultado->bindValue(':nombre_usuario', $nombre_usuario);

    // Ejecuta la consulta preparada
    $resultado->execute();

    // Obtiene el número de filas afectadas por la consulta
    $numero_registro = $resultado->rowCount();

    // Verifica si se encontraron registros
    if ($numero_registro != 0) {
        // Redirige a index.php si se encontraron registros
        header('Location: index.php');
    } else {
        // Redirige a RegistroUsuarios.php si no se encontraron registros
        header('Location: RegistroUsuarios.php');
    }
} catch (Exception $e) {
    // Maneja cualquier excepción que pueda ocurrir durante el proceso
    die('Error: ' . $e->getMessage());
}
?>

