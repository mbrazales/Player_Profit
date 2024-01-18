<?php


    //Datos de la conexion a la base de datos 
    
        $servername = "localhost";//Nombre del servidor
        $database = "profit";//Nombre de la base de datos
        $username = "adefifa";//Nombre del usuario de la base de datos
        $password = "root";//Contraseña de la base de datos

        // Establecer la conexión con la base de datos utilizando mysqli
        $conexion = mysqli_connect($servername, $username, $password, $database);

        // Verificar si la conexión fue exitosa
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        } else {
        
        }
?>