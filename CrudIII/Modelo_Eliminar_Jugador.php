<?php
    //Conexión
    include "Config/conexion.php";

    //Recuperamos con Request el dato que enviamos tanto con GET o POST
    $id = $_REQUEST['id'];

    // Crear una consulta para eliminar la fila de la tabla 'jugadores' donde el ID coincida con el valor recibido
    $sql = "DELETE FROM jugadores WHERE id = $id";

    // Ejecutar la consulta DELETE en la base de datos a través de la conexión establecida
    $resultado = $conexion -> query($sql);

    // Verificar si la consulta se ejecutó con éxito
    if ($resultado) {
        // Redirigir a la página 'index.php' si se eliminó la fila correctamente
        header("Location: index.php");
    }else {
        echo "No se ha eliminado el jugador";
    }

?>