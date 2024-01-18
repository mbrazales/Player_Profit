<?php 
    // Configuración para mostrar errores (en este caso, se ha configurado para mostrar errores)
    error_reporting(1);

    // Incluimos el archivo de conexión a la base de datos
    include 'Config/conexion.php';

    // Recuperamos el ID del jugador que queremos editar, enviado ya sea por GET o POST
    $id = $_REQUEST['idEditar'];

    // Recuperamos el nombre del jugador enviado por POST
    $nombre = $_POST['nombre'];

    // Obtenemos la imagen y la convertimos en datos binarios para almacenarla en la base de datos
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    // Recuperamos la calidad del jugador enviado por POST
    $calidad = $_POST['calidad'];

    // Creamos la consulta SQL para actualizar la información del jugador
    $Sql = "UPDATE jugadores SET nombre = '$nombre', imagen = '$imagen', calidad = '$calidad' WHERE id = '$id'";

    // Ejecutamos la consulta en la base de datos
    $resultado = $conexion->query($Sql);

    // Verificamos si la consulta fue exitosa
    if ($resultado) {
        // Si fue exitosa, redireccionamos a la página index.php
        header('Location: index.php');
    } else {
        // Si no fue exitosa, mostramos un mensaje de error
        echo 'No se ha editado al Jugador';
    }
?>
